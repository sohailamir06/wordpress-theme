<?php
/**
 * Cool Air USA — Theme Functions
 */

if ( ! defined( 'ABSPATH' ) ) exit;

define( 'CA_THEME_VERSION', '1.0.0' );
define( 'CA_THEME_DIR', get_template_directory() );
define( 'CA_THEME_URI', get_template_directory_uri() );
define( 'CA_PHONE',     '(954) 915-1155' );
define( 'CA_PHONE_RAW', '9549151155' );
define( 'CA_EMAIL',     'support@coolairusa.com' );
define( 'CA_ADDRESS',   '3901 NW 16th St, Fort Lauderdale, FL 33311' );
define( 'CA_PORTAL',    'http://coolairusa.myservicetitan.com' );

require_once CA_THEME_DIR . '/inc/page-data.php';
require_once CA_THEME_DIR . '/inc/render-services.php';
require_once CA_THEME_DIR . '/inc/render-pages.php';
require_once CA_THEME_DIR . '/inc/render-home.php';

add_action( 'after_setup_theme', function () {
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'editor-styles' );
	add_editor_style( 'assets/css/main.css' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', [ 'search-form','comment-form','comment-list','gallery','caption','script','style' ] );
} );

add_action( 'wp_enqueue_scripts', function () {
	wp_enqueue_style(
		'ca-fonts',
		'https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@600;700;800;900&family=Barlow:wght@300;400;500;600;700&display=swap',
		[],
		null
	);
	wp_enqueue_style( 'ca-main', CA_THEME_URI . '/assets/css/main.css', [], CA_THEME_VERSION );
	wp_enqueue_script( 'ca-nav',  CA_THEME_URI . '/assets/js/nav.js',  [], CA_THEME_VERSION, true );
	wp_enqueue_script( 'ca-main', CA_THEME_URI . '/assets/js/main.js', [], CA_THEME_VERSION, true );
} );

add_action( 'enqueue_block_assets', function () {
	if ( ! is_admin() ) {
		return;
	}

	wp_enqueue_style(
		'ca-fonts',
		'https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@600;700;800;900&family=Barlow:wght@300;400;500;600;700&display=swap',
		[],
		null
	);
	wp_enqueue_style( 'ca-main', CA_THEME_URI . '/assets/css/main.css', [], CA_THEME_VERSION );
} );

add_action( 'init', function () {
	wp_register_script(
		'ca-editor-blocks',
		CA_THEME_URI . '/assets/js/editor-blocks.js',
		[ 'wp-blocks', 'wp-element', 'wp-server-side-render', 'wp-i18n' ],
		CA_THEME_VERSION,
		true
	);
} );

add_action( 'init', function () {
	register_block_pattern_category( 'cool-air-usa', [ 'label' => 'Cool Air USA' ] );

	foreach ( ca_dynamic_block_definitions() as $block_name => $settings ) {
		if ( ! empty( $settings['render_callback'] ) ) {
			$settings['render_callback'] = ca_dynamic_block_wrapper( $settings['render_callback'] );
		}
		register_block_type( $block_name, $settings );
	}
} );

add_action( 'after_switch_theme', 'ca_sync_theme_pages_with_admin' );
add_action( 'admin_init', 'ca_sync_theme_pages_with_admin' );
add_action( 'save_post_page', 'ca_sync_theme_page_on_save', 20, 3 );
add_filter( 'allowed_block_types_all', 'ca_allowed_block_types_all', 10, 2 );
add_filter( 'block_editor_settings_all', 'ca_block_editor_builder_settings', 10, 2 );

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
			'render'     => 'ca_render_homepage',
			'set_front'  => true,
		],
		'about'            => [ 'title' => 'About',            'template' => 'page-about.html',            'render' => 'ca_render_about_page' ],
		'contact'          => [ 'title' => 'Contact',          'template' => 'page-contact.html',          'render' => 'ca_render_contact_page' ],
		'membership'       => [ 'title' => 'Membership',       'template' => 'page-membership.html',       'render' => 'ca_render_membership_page' ],
		'financing'        => [ 'title' => 'Financing',        'template' => 'page-financing.html',        'render' => 'ca_render_financing_page' ],
		'careers'          => [ 'title' => 'Careers',          'template' => 'page-careers.html',          'render' => 'ca_render_careers_page' ],
		'specials'         => [ 'title' => 'Specials & Deals', 'template' => 'page-specials.html',         'render' => 'ca_render_specials_page' ],
		'brands'           => [ 'title' => 'Brands',           'template' => 'page-brands.html',           'render' => 'ca_render_brands_page' ],
		'service-areas'    => [ 'title' => 'Service Areas',    'template' => 'page-service-areas.html',    'render' => 'ca_render_service_areas_page' ],
		'privacy-policy'   => [ 'title' => 'Privacy Policy',   'template' => 'page-privacy-policy.html',   'render' => function () { return ca_render_legal_page( [ 'kind' => 'privacy' ] ); } ],
		'terms-of-service' => [ 'title' => 'Terms of Service', 'template' => 'page-terms-of-service.html', 'render' => function () { return ca_render_legal_page( [ 'kind' => 'terms' ] ); } ],
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
				return ca_render_service_page( $service_slug );
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
		ca_normalize_editable_block_wrapper( $page_id );

		if ( ! empty( $config['render'] ) && is_callable( $config['render'] ) ) {
			ca_seed_post_content_if_empty( $page_id, $config['render'], '' );
		}
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
	if ( 'page' !== get_option( 'show_on_front' ) ) {
		update_option( 'show_on_front', 'page' );
	}
	if ( (int) get_option( 'page_on_front' ) !== $home_id ) {
		update_option( 'page_on_front', $home_id );
	}
}

/**
 * Curate block inserter list for a page-builder-like editing experience.
 *
 * @param bool|array               $allowed_block_types Allowed block types.
 * @param WP_Block_Editor_Context  $context             Editor context.
 * @return bool|array
 */
function ca_allowed_block_types_all( $allowed_block_types, $context ) {
	if ( empty( $context->post ) ) {
		return $allowed_block_types;
	}

	$post_type = get_post_type( $context->post );
	if ( ! in_array( $post_type, [ 'page', 'wp_template', 'wp_template_part' ], true ) ) {
		return $allowed_block_types;
	}

	return [
		'core/group',
		'core/columns',
		'core/column',
		'core/cover',
		'core/media-text',
		'core/spacer',
		'core/separator',
		'core/heading',
		'core/paragraph',
		'core/list',
		'core/quote',
		'core/buttons',
		'core/button',
		'core/image',
		'core/gallery',
		'core/video',
		'core/file',
		'core/freeform',
		'core/shortcode',
		'core/template-part',
		'core/post-content',
		'core/post-title',
		'core/query',
		'core/query-title',
		'core/query-pagination',
		'core/query-pagination-next',
		'core/query-pagination-previous',
		'core/query-pagination-numbers',
		'core/site-logo',
		'core/site-title',
		'core/site-tagline',
		'core/navigation',
		'core/navigation-link',
		'core/navigation-submenu',
		'core/social-links',
		'core/social-link',
	];
}

/**
 * Force visual editing defaults to keep Gutenberg "builder-like" for editors.
 *
 * @param array                    $settings Editor settings.
 * @param WP_Block_Editor_Context  $context  Editor context.
 * @return array
 */
function ca_block_editor_builder_settings( $settings, $context ) {
	$settings['codeEditingEnabled'] = false;
	$settings['richEditingEnabled'] = true;
	$settings['focusMode']          = false;
	$settings['fixedToolbar']       = true;
	$settings['keepCaretInsideBlock'] = true;
	$settings['enableOpenverseMediaCategory'] = false;

	if ( ! empty( $context->post ) ) {
		$post_type = get_post_type( $context->post );
		if ( in_array( $post_type, [ 'page', 'wp_template', 'wp_template_part' ], true ) ) {
			$settings['defaultMode'] = 'visual';
		}
	}

	return $settings;
}

/**
 * Backward-compatible wrapper.
 */
function ca_seed_static_design_content() {
	ca_sync_theme_pages_with_admin();
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

	$updated = wp_update_post(
		[
			'ID'           => $post_id,
			'post_content' => ca_wrap_editable_content_block( $html ),
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
 * Wrap arbitrary HTML in a visual-editable Classic (freeform) block.
 *
 * @param string $html Raw HTML markup.
 * @return string
 */
function ca_wrap_editable_content_block( $html ) {
	return "<!-- wp:freeform -->\n" . trim( $html ) . "\n<!-- /wp:freeform -->";
}

/**
 * Convert old core/html wrappers into visual-editable freeform wrappers.
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
	$open    = '<!-- wp:html -->';
	$close   = '<!-- /wp:html -->';

	if ( ! str_starts_with( $content, $open ) || ! str_ends_with( $content, $close ) ) {
		return;
	}

	$inner = substr( $content, strlen( $open ), -strlen( $close ) );
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

add_filter( 'should_load_remote_block_patterns', '__return_false' );

/**
 * Wrap dynamic block output so block supports (spacing/alignment/etc.) are rendered.
 *
 * @param callable $callback Dynamic block callback.
 * @return callable
 */
function ca_dynamic_block_wrapper( $callback ) {
	return function ( $attributes = [], $content = '' ) use ( $callback ) {
		$output = ca_call_dynamic_callback( $callback, $attributes, $content );
		if ( ! is_string( $output ) || '' === trim( $output ) ) {
			return '';
		}

		return sprintf(
			'<div %1$s>%2$s</div>',
			get_block_wrapper_attributes(),
			$output
		);
	};
}

/**
 * Invoke dynamic callbacks while respecting each function signature.
 *
 * @param callable $callback   Callback function.
 * @param array    $attributes Parsed block attributes.
 * @param string   $content    Block content.
 * @return string
 */
function ca_call_dynamic_callback( $callback, $attributes, $content ) {
	if ( ! is_callable( $callback ) ) {
		return '';
	}

	try {
		$reflection = is_array( $callback )
			? new ReflectionMethod( $callback[0], $callback[1] )
			: new ReflectionFunction( $callback );
	} catch ( ReflectionException $e ) {
		return '';
	}

	$args       = [];
	$param_count = $reflection->getNumberOfParameters();

	if ( $param_count >= 1 ) {
		$args[] = $attributes;
	}
	if ( $param_count >= 2 ) {
		$args[] = $content;
	}

	return (string) call_user_func_array( $callback, $args );
}

/**
 * Shared metadata for server-rendered theme blocks.
 */
function ca_dynamic_block_definitions() {
	$common = [
		'api_version'   => 3,
		'editor_script' => 'ca-editor-blocks',
		'category'      => 'theme',
		'supports'      => [
			'html'       => false,
			'align'      => [ 'wide', 'full' ],
			'spacing'    => [
				'margin'  => true,
				'padding' => true,
			],
			'dimensions' => [
				'minHeight' => true,
			],
		],
	];

	return [
		'cool-air-usa/site-header' => $common + [
			'title'           => 'Site Header',
			'description'     => 'Primary header and navigation.',
			'icon'            => 'editor-kitchensink',
			'render_callback' => 'ca_render_site_header',
		],
		'cool-air-usa/site-footer' => $common + [
			'title'           => 'Site Footer',
			'description'     => 'Global footer and legal links.',
			'icon'            => 'editor-kitchensink',
			'render_callback' => 'ca_render_site_footer',
		],
		'cool-air-usa/homepage' => $common + [
			'title'           => 'Homepage',
			'description'     => 'Homepage sections rendered in theme order.',
			'icon'            => 'layout',
			'render_callback' => 'ca_render_homepage',
		],
		'cool-air-usa/service-page' => $common + [
			'title'           => 'Service Page',
			'description'     => 'Dynamic service page content based on the current page slug.',
			'icon'            => 'admin-tools',
			'render_callback' => 'ca_render_service_page_block',
		],
		'cool-air-usa/about-page' => $common + [
			'title'           => 'About Page',
			'description'     => 'About page layout.',
			'icon'            => 'id',
			'render_callback' => 'ca_render_about_page',
		],
		'cool-air-usa/contact-page' => $common + [
			'title'           => 'Contact Page',
			'description'     => 'Contact page layout.',
			'icon'            => 'email',
			'render_callback' => 'ca_render_contact_page',
		],
		'cool-air-usa/membership-page' => $common + [
			'title'           => 'Membership Page',
			'description'     => 'Membership plans page layout.',
			'icon'            => 'groups',
			'render_callback' => 'ca_render_membership_page',
		],
		'cool-air-usa/financing-page' => $common + [
			'title'           => 'Financing Page',
			'description'     => 'Financing page layout.',
			'icon'            => 'money-alt',
			'render_callback' => 'ca_render_financing_page',
		],
		'cool-air-usa/careers-page' => $common + [
			'title'           => 'Careers Page',
			'description'     => 'Careers page layout.',
			'icon'            => 'businessperson',
			'render_callback' => 'ca_render_careers_page',
		],
		'cool-air-usa/specials-page' => $common + [
			'title'           => 'Specials Page',
			'description'     => 'Special offers page layout.',
			'icon'            => 'tickets-alt',
			'render_callback' => 'ca_render_specials_page',
		],
		'cool-air-usa/brands-page' => $common + [
			'title'           => 'Brands Page',
			'description'     => 'Brands page layout.',
			'icon'            => 'tag',
			'render_callback' => 'ca_render_brands_page',
		],
		'cool-air-usa/service-areas-page' => $common + [
			'title'           => 'Service Areas Page',
			'description'     => 'Service areas page layout.',
			'icon'            => 'location-alt',
			'render_callback' => 'ca_render_service_areas_page',
		],
		'cool-air-usa/legal-page' => $common + [
			'title'           => 'Legal Page',
			'description'     => 'Privacy policy or terms of service page.',
			'icon'            => 'media-document',
			'render_callback' => 'ca_render_legal_page',
			'attributes'      => [
				'kind' => [
					'type'    => 'string',
					'default' => 'privacy',
				],
			],
		],
	];
}

/**
 * Determine which service slug applies to current page.
 * Falls back to 'ac-repair' if no match.
 */
function ca_current_service_slug() {
	$post_slug = get_post_field( 'post_name', get_queried_object_id() );
	$slugs     = array_keys( ca_service_data() );
	if ( in_array( $post_slug, $slugs, true ) ) return $post_slug;
	$qs = isset( $_GET['service'] ) ? sanitize_title( $_GET['service'] ) : '';
	if ( $qs && in_array( $qs, $slugs, true ) ) return $qs;
	return 'ac-repair';
}

/**
 * Tel URL helper.
 */
function ca_tel( $label = null ) {
	return '<a class="ca-tel" href="tel:' . CA_PHONE_RAW . '">' . ( $label ?: '📞 ' . CA_PHONE ) . '</a>';
}

/**
 * Helper for "current year".
 */
function ca_year() {
	return gmdate( 'Y' );
}

/**
 * Allow safe SVG output via wp_kses.
 */
function ca_kses_svg( $html ) {
	return wp_kses( $html, [
		'svg'      => [ 'xmlns' => true, 'viewbox' => true, 'width' => true, 'height' => true, 'fill' => true, 'stroke' => true, 'class' => true, 'style' => true ],
		'g'        => [ 'fill' => true, 'transform' => true ],
		'path'     => [ 'd' => true, 'fill' => true, 'stroke' => true, 'stroke-width' => true, 'opacity' => true ],
		'rect'     => [ 'x' => true, 'y' => true, 'width' => true, 'height' => true, 'rx' => true, 'fill' => true, 'opacity' => true ],
		'circle'   => [ 'cx' => true, 'cy' => true, 'r' => true, 'fill' => true, 'opacity' => true ],
		'text'     => [ 'x' => true, 'y' => true, 'font-family' => true, 'font-size' => true, 'font-weight' => true, 'fill' => true, 'letter-spacing' => true ],
		'animate'  => [ 'attributename' => true, 'values' => true, 'dur' => true, 'repeatcount' => true ],
	] );
}
