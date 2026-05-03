<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'init', function () {
	register_block_pattern_category( 'cool-air-usa', [ 'label' => 'Cool Air USA' ] );

	foreach ( ca_dynamic_block_definitions() as $block_name => $settings ) {
		if ( ! empty( $settings['render_callback'] ) ) {
			$settings['render_callback'] = ca_dynamic_block_wrapper( $settings['render_callback'] );
		}
		register_block_type( $block_name, $settings );
	}
} );
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
