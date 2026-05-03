<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_filter( 'allowed_block_types_all', 'ca_allowed_block_types_all', 10, 2 );
add_filter( 'block_editor_settings_all', 'ca_block_editor_builder_settings', 10, 2 );
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

	$allowed = [
		'core/group',
		'core/row',
		'core/stack',
		'core/columns',
		'core/column',
		'core/cover',
		'core/media-text',
		'core/spacer',
		'core/separator',
		'core/heading',
		'core/paragraph',
		'core/list',
		'core/list-item',
		'core/quote',
		'core/pullquote',
		'core/table',
		'core/buttons',
		'core/button',
		'core/image',
		'core/gallery',
		'core/video',
		'core/file',
		'core/html',
		'core/shortcode',
		'core/details',
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

	if ( function_exists( 'ca_dynamic_block_definitions' ) ) {
		$theme_blocks = array_keys( ca_dynamic_block_definitions() );
		$allowed      = array_merge( $allowed, $theme_blocks );
	}

	return $allowed;
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
	$settings['fixedToolbar']       = false;
	$settings['keepCaretInsideBlock'] = true;
	$settings['enableOpenverseMediaCategory'] = false;

	if ( ! empty( $context->post ) ) {
		$post_type = get_post_type( $context->post );
		if ( in_array( $post_type, [ 'page', 'wp_template', 'wp_template_part' ], true ) ) {
			$settings['defaultMode'] = 'visual';
		}
		if ( 'page' === $post_type ) {
			// Keep editors in page-content mode instead of template-edit mode.
			$settings['supportsTemplateMode'] = false;
		}
	}

	return $settings;
}

/**
 * Backward-compatible wrapper.
