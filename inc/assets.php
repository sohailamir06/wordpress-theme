<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

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
	wp_enqueue_style( 'ca-editor-fix', CA_THEME_URI . '/assets/css/editor-style.css', [], CA_THEME_VERSION );
	wp_enqueue_script( 'ca-editor-enhancements', CA_THEME_URI . '/assets/js/editor-enhancements.js', [], CA_THEME_VERSION, true );
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
