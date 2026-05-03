<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'after_setup_theme', function () {
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'editor-styles' );
	add_editor_style( [ 'assets/css/main.css', 'assets/css/editor-style.css' ] );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', [ 'search-form','comment-form','comment-list','gallery','caption','script','style' ] );
	register_nav_menus(
		[
			'primary'        => __( 'Primary Menu', 'cool-air-usa' ),
			'footer_hvac'    => __( 'Footer HVAC Services', 'cool-air-usa' ),
			'footer_more'    => __( 'Footer More Services', 'cool-air-usa' ),
			'footer_company' => __( 'Footer Company', 'cool-air-usa' ),
			'footer_legal'   => __( 'Footer Legal', 'cool-air-usa' ),
		]
	);
} );
