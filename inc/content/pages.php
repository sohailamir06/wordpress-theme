<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'after_switch_theme', 'ca_sync_theme_pages_with_admin' );
add_action( 'admin_init', 'ca_sync_theme_pages_with_admin' );
add_action( 'save_post_page', 'ca_sync_theme_page_on_save', 20, 3 );

/**
 * Canonical page map used to auto-provision and synchronize page structure.
 *
 * @return array<string,array<string,mixed>>
 */
function ca_theme_page_blueprint() {
	$pages = [
		'home'             => [
			'title'      => 'Home',
			'template'   => '',
			'render'     => 'ca_render_homepage_builder_content',
			'set_front'  => true,
		],
		'about'            => [ 'title' => 'About',            'template' => 'page-about.html',            'render' => 'ca_render_about_page_builder_content' ],
		'contact'          => [ 'title' => 'Contact',          'template' => 'page-contact.html',          'render' => 'ca_render_contact_page_builder_content' ],
		'membership'       => [ 'title' => 'Membership',       'template' => 'page-membership.html',       'render' => 'ca_render_membership_page_builder_content' ],
		'financing'        => [ 'title' => 'Financing',        'template' => 'page-financing.html',        'render' => 'ca_render_financing_page_builder_content' ],
		'careers'          => [ 'title' => 'Careers',          'template' => 'page-careers.html',          'render' => 'ca_render_careers_page_builder_content' ],
		'specials'         => [ 'title' => 'Specials & Deals', 'template' => 'page-specials.html',         'render' => 'ca_render_specials_page_builder_content' ],
		'brands'           => [ 'title' => 'Brands',           'template' => 'page-brands.html',           'render' => 'ca_render_brands_page_builder_content' ],
		'service-areas'    => [ 'title' => 'Service Areas',    'template' => 'page-service-areas.html',    'render' => 'ca_render_service_areas_page_builder_content' ],
		'privacy-policy'   => [ 'title' => 'Privacy Policy',   'template' => 'page-privacy-policy.html',   'render' => function () { return ca_render_legal_page_builder_content( 'privacy' ); } ],
		'terms-of-service' => [ 'title' => 'Terms of Service', 'template' => 'page-terms-of-service.html', 'render' => function () { return ca_render_legal_page_builder_content( 'terms' ); } ],
		'services'         => [ 'title' => 'Services',         'template' => 'page-services.html',         'render' => '' ],
	];

	foreach ( ca_service_data() as $service_slug => $service ) {
		$title = ! empty( $service['title'] )
			? (string) $service['title']
			: ucwords( str_replace( '-', ' ', $service_slug ) );

		$pages[ 'services/' . $service_slug ] = [
			'title'       => $title,
			'parent_path' => 'services',
			'template'    => 'page-services.html',
			'render'      => function () use ( $service_slug ) {
				return ca_render_service_page_builder_content( $service_slug );
			},
		];
	}

	return $pages;
}

/**
 * Ensure required pages exist and stay synchronized with templates/content defaults.
 *
 * @return void
 */
function ca_sync_theme_pages_with_admin() {
	if ( wp_doing_ajax() ) {
		return;
	}
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	static $running = false;
	if ( $running ) {
		return;
	}
	$running = true;

	$blueprint = ca_theme_page_blueprint();
	$page_ids  = [];

	foreach ( $blueprint as $path => $config ) {
		$page_id = ca_ensure_theme_page( $path, $config );
		if ( $page_id <= 0 ) {
			continue;
		}

		$page_ids[ $path ] = $page_id;

		ca_apply_page_template( $page_id, isset( $config['template'] ) ? (string) $config['template'] : '' );
		ca_migrate_legacy_page_content_to_blocks( $page_id, $path, $config );
		ca_normalize_editable_block_wrapper( $page_id );

		if ( ! empty( $config['render'] ) && is_callable( $config['render'] ) ) {
			ca_seed_post_content_if_empty( $page_id, $config['render'], '' );
		}

		// Expand pattern references into concrete block trees on the front page so
		// Gutenberg loads all sections as directly editable content.
		ca_expand_front_page_pattern_references( $page_id, $path );
		ca_refresh_legacy_home_hero_section( $page_id, $path );
		ca_refresh_legacy_home_gallery_section( $page_id, $path );
		ca_refresh_legacy_home_stats_section( $page_id, $path );
		ca_refresh_legacy_home_reviews_section( $page_id, $path );
		ca_refresh_legacy_home_process_section( $page_id, $path );
		ca_refresh_legacy_home_brands_section( $page_id, $path );
	}

	if ( ! empty( $page_ids['home'] ) ) {
		ca_set_front_page( (int) $page_ids['home'] );
	}

	$running = false;
}

/**
 * Keep mapped page template/structure synchronized whenever a page is saved.
 *
 * @param int     $post_id Post ID.
 * @param WP_Post $post    Post object.
 * @param bool    $update  Whether this is an update.
 * @return void
 */
function ca_sync_theme_page_on_save( $post_id, $post, $update ) {
	if ( ! $update && 'auto-draft' === $post->post_status ) {
		return;
	}
	if ( wp_is_post_autosave( $post_id ) || wp_is_post_revision( $post_id ) ) {
		return;
	}
	if ( 'trash' === $post->post_status ) {
		return;
	}

	static $running = false;
	if ( $running ) {
		return;
	}
	$running = true;

	$path      = ca_page_path_from_id( $post_id );
	$blueprint = ca_theme_page_blueprint();

	if ( $path && isset( $blueprint[ $path ] ) ) {
		$config = $blueprint[ $path ];

		if ( ! empty( $config['parent_path'] ) ) {
			$parent = get_page_by_path( (string) $config['parent_path'], OBJECT, 'page' );
			if ( $parent && (int) $post->post_parent !== (int) $parent->ID ) {
				wp_update_post(
					[
						'ID'          => $post_id,
						'post_parent' => (int) $parent->ID,
					]
				);
			}
		}

		ca_apply_page_template( $post_id, isset( $config['template'] ) ? (string) $config['template'] : '' );
		ca_expand_front_page_pattern_references( $post_id, $path );
		ca_refresh_legacy_home_hero_section( $post_id, $path );
		ca_refresh_legacy_home_gallery_section( $post_id, $path );
		ca_refresh_legacy_home_stats_section( $post_id, $path );
		ca_refresh_legacy_home_reviews_section( $post_id, $path );
		ca_refresh_legacy_home_process_section( $post_id, $path );
		ca_refresh_legacy_home_brands_section( $post_id, $path );
	}

	$running = false;
}

/**
 * Ensure a page exists for a blueprint path.
 *
 * @param string $path   Relative page path, e.g. services/ac-repair.
 * @param array  $config Blueprint item.
 * @return int
 */
function ca_ensure_theme_page( $path, $config ) {
	$page = get_page_by_path( $path, OBJECT, 'page' );
	if ( $page && ! empty( $page->ID ) ) {
		return (int) $page->ID;
	}

	$parent_id = 0;
	if ( ! empty( $config['parent_path'] ) ) {
		$parent = get_page_by_path( (string) $config['parent_path'], OBJECT, 'page' );
		if ( $parent && ! empty( $parent->ID ) ) {
			$parent_id = (int) $parent->ID;
		}
	}

	$slug = basename( $path );
	$id   = wp_insert_post(
		[
			'post_type'    => 'page',
			'post_status'  => 'publish',
			'post_title'   => isset( $config['title'] ) ? (string) $config['title'] : ucwords( str_replace( '-', ' ', $slug ) ),
			'post_name'    => $slug,
			'post_parent'  => $parent_id,
			'post_content' => '',
		],
		true
	);

	if ( is_wp_error( $id ) ) {
		return 0;
	}

	return (int) $id;
}

/**
 * Apply page template metadata.
 *
 * @param int    $post_id  Page ID.
 * @param string $template Template file name.
 * @return void
 */
function ca_apply_page_template( $post_id, $template ) {
	if ( '' === $template ) {
		return;
	}
	$current = (string) get_post_meta( $post_id, '_wp_page_template', true );
	if ( $current !== $template ) {
		update_post_meta( $post_id, '_wp_page_template', $template );
	}
}

/**
 * Resolve full relative page path by ID.
 *
 * @param int $post_id Page ID.
 * @return string
 */
function ca_page_path_from_id( $post_id ) {
	$uri = get_page_uri( $post_id );
	return is_string( $uri ) ? trim( $uri, '/' ) : '';
}

/**
 * Configure static front page assignment.
 *
 * @param int $home_id Home page ID.
 * @return void
 */
function ca_set_front_page( $home_id ) {
	if ( $home_id <= 0 ) {
		return;
	}

	if ( (int) get_option( 'page_on_front' ) === $home_id ) {
		return;
	}

	update_option( 'show_on_front', 'page' );
	update_option( 'page_on_front', $home_id );
}

/**
 * Fill a page with block HTML content if it has not been authored yet.
 *
 * @param int      $post_id   Page ID.
 * @param callable $renderer  HTML renderer callback.
 * @param string   $template  Optional template filename.
 */
function ca_seed_post_content_if_empty( $post_id, $renderer, $template = '' ) {
	$post = get_post( $post_id );
	if ( ! $post || 'page' !== $post->post_type ) {
		return;
	}

	$existing = trim( (string) $post->post_content );
	if ( '' !== $existing ) {
		if ( $template ) {
			$current = (string) get_post_meta( $post_id, '_wp_page_template', true );
			if ( '' === $current || 'default' === $current ) {
				update_post_meta( $post_id, '_wp_page_template', $template );
			}
		}
		return;
	}

	$html = ca_call_dynamic_callback( $renderer, [], '' );
	if ( '' === trim( $html ) ) {
		return;
	}

	$content = ca_wrap_editable_content_block( $html );
	if ( ca_is_block_markup( $html ) ) {
		$content = trim( $html );
	}

	$updated = wp_update_post(
		[
			'ID'           => $post_id,
			'post_content' => $content,
		],
		true
	);

	if ( is_wp_error( $updated ) ) {
		return;
	}

	if ( $template ) {
		update_post_meta( $post_id, '_wp_page_template', $template );
	}
}

/**
 * Build editable block markup from raw HTML.
 *
 * @param string $html Raw HTML markup.
 * @return string
 */
function ca_wrap_editable_content_block( $html ) {
	return "<!-- wp:html -->\n" . trim( $html ) . "\n<!-- /wp:html -->";
}

/**
 * Determine whether markup already contains native block comments.
 *
 * @param string $markup Potential block markup.
 * @return bool
 */
function ca_is_block_markup( $markup ) {
	return false !== strpos( (string) $markup, '<!-- wp:' );
}

/**
 * Convert old freeform wrappers into non-Classic block wrappers.
 *
 * @param int $post_id Page ID.
 * @return void
 */
function ca_normalize_editable_block_wrapper( $post_id ) {
	$post = get_post( $post_id );
	if ( ! $post || 'page' !== $post->post_type ) {
		return;
	}

	$content = trim( (string) $post->post_content );
	$freeform_open  = '<!-- wp:freeform -->';
	$freeform_close = '<!-- /wp:freeform -->';

	if ( ! str_starts_with( $content, $freeform_open ) || ! str_ends_with( $content, $freeform_close ) ) {
		return;
	}

	$inner = substr( $content, strlen( $freeform_open ), -strlen( $freeform_close ) );
	$new   = ca_wrap_editable_content_block( $inner );

	if ( $new === $content ) {
		return;
	}

	wp_update_post(
		[
			'ID'           => $post_id,
			'post_content' => $new,
		]
	);
}

/**
 * Compose homepage content from native editable pattern references.
 *
 * @return string
 */
function ca_render_homepage_builder_content() {
	$patterns = [
		'cool-air-usa/home-hero',
		'cool-air-usa/home-stats-bar',
		'cool-air-usa/home-family-band',
		'cool-air-usa/home-services',
		'cool-air-usa/home-why',
		'cool-air-usa/home-reviews',
		'cool-air-usa/home-process',
		'cool-air-usa/home-brands',
		'cool-air-usa/home-map',
		'cool-air-usa/home-membership-cta',
		'cool-air-usa/home-gallery',
		'cool-air-usa/home-emergency',
	];

	$lines = array_map(
		static function ( $slug ) {
			return sprintf( '<!-- wp:pattern {"slug":"%s"} /-->', $slug );
		},
		$patterns
	);

	return implode( "\n\n", $lines );
}

/**
 * Migrate known legacy homepage content to editable block patterns.
 *
 * @param int    $post_id Page ID.
 * @param string $path    Blueprint page path.
 * @param array  $config  Blueprint config.
 * @return void
 */
function ca_migrate_legacy_page_content_to_blocks( $post_id, $path, $config = [] ) {
	$post = get_post( $post_id );
	if ( ! $post || 'page' !== $post->post_type ) {
		return;
	}

	$content = trim( (string) $post->post_content );
	if ( '' === $content ) {
		return;
	}

	$is_freeform_wrapper = str_starts_with( $content, '<!-- wp:freeform -->' ) && str_ends_with( $content, '<!-- /wp:freeform -->' );
	$is_html_wrapper     = str_starts_with( $content, '<!-- wp:html -->' ) && str_ends_with( $content, '<!-- /wp:html -->' );
	$is_dynamic_wrapper  = 1 === preg_match( '/^<!--\s+wp:cool-air-usa\/[a-z0-9-]+\s*\/-->$/', $content );

	if ( ! $is_freeform_wrapper && ! $is_html_wrapper && ! $is_dynamic_wrapper ) {
		return;
	}

	$renderer = isset( $config['render'] ) ? $config['render'] : '';
	if ( ! is_callable( $renderer ) ) {
		return;
	}

	$migrated = (string) ca_call_dynamic_callback( $renderer, [], '' );
	if ( trim( $migrated ) === $content ) {
		return;
	}

	wp_update_post(
		[
			'ID'           => $post_id,
			'post_content' => $migrated,
		]
	);
}
