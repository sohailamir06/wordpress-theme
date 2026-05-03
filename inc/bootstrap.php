<?php
/**
 * Load theme modules in dependency order.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$ca_theme_includes = [
	'/inc/helpers.php',
	'/inc/data/site.php',
	'/inc/render/service.php',
	'/inc/render/pages.php',
	'/inc/render/home.php',
	'/inc/content/builders.php',
	'/inc/setup.php',
	'/inc/assets.php',
	'/inc/forms/contact.php',
	'/inc/blocks.php',
	'/inc/menus.php',
	'/inc/editor.php',
	'/inc/content/migrations.php',
	'/inc/content/pages.php',
];

foreach ( $ca_theme_includes as $ca_theme_include ) {
	require_once CA_THEME_DIR . $ca_theme_include;
}

unset( $ca_theme_include, $ca_theme_includes );
