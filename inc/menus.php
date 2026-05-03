<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'after_switch_theme', 'ca_ensure_primary_menu' );
add_action( 'admin_init', 'ca_ensure_primary_menu' );
add_action( 'after_switch_theme', 'ca_ensure_footer_menus' );
add_action( 'admin_init', 'ca_ensure_footer_menus' );
/**
 * Create and assign the default Primary Menu only when the site has none.
 *
 * @return void
 */
function ca_ensure_primary_menu() {
	if ( is_admin() && ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$locations = (array) get_theme_mod( 'nav_menu_locations', [] );
	if ( ! empty( $locations['primary'] ) ) {
		return;
	}

	$menu    = wp_get_nav_menu_object( 'Primary Menu' );
	$menu_id = $menu && ! is_wp_error( $menu ) ? (int) $menu->term_id : 0;

	if ( $menu_id <= 0 ) {
		$created = wp_create_nav_menu( 'Primary Menu' );
		if ( is_wp_error( $created ) ) {
			return;
		}
		$menu_id = (int) $created;
	}

	$existing_items = wp_get_nav_menu_items( $menu_id );
	if ( empty( $existing_items ) && function_exists( 'ca_default_primary_menu_items' ) ) {
		ca_seed_nav_menu_items( $menu_id, ca_default_primary_menu_items() );
	}

	$locations['primary'] = $menu_id;
	set_theme_mod( 'nav_menu_locations', $locations );
}

/**
 * Create and assign default footer menus only when their locations are empty.
 *
 * @return void
 */
function ca_ensure_footer_menus() {
	if ( is_admin() && ! current_user_can( 'manage_options' ) ) {
		return;
	}

	if ( ! function_exists( 'ca_default_footer_menus' ) ) {
		return;
	}

	$locations = (array) get_theme_mod( 'nav_menu_locations', [] );

	foreach ( ca_default_footer_menus() as $location => $config ) {
		if ( ! empty( $locations[ $location ] ) ) {
			continue;
		}

		$menu_name = isset( $config['name'] ) ? (string) $config['name'] : ucwords( str_replace( '_', ' ', $location ) );
		$menu      = wp_get_nav_menu_object( $menu_name );
		$menu_id   = $menu && ! is_wp_error( $menu ) ? (int) $menu->term_id : 0;

		if ( $menu_id <= 0 ) {
			$created = wp_create_nav_menu( $menu_name );
			if ( is_wp_error( $created ) ) {
				continue;
			}
			$menu_id = (int) $created;
		}

		$existing_items = wp_get_nav_menu_items( $menu_id );
		if ( empty( $existing_items ) && ! empty( $config['items'] ) && is_array( $config['items'] ) ) {
			ca_seed_nav_menu_items( $menu_id, $config['items'] );
		}

		$locations[ $location ] = $menu_id;
	}

	set_theme_mod( 'nav_menu_locations', $locations );
}

/**
 * Seed menu items recursively from the theme defaults.
 *
 * @param int                  $menu_id   Nav menu term ID.
 * @param array<int,array>     $items     Menu item definitions.
 * @param int                  $parent_id Parent menu item ID.
 * @return void
 */
function ca_seed_nav_menu_items( $menu_id, $items, $parent_id = 0 ) {
	foreach ( $items as $item ) {
		$item_id = wp_update_nav_menu_item(
			$menu_id,
			0,
			[
				'menu-item-title'     => isset( $item['title'] ) ? (string) $item['title'] : '',
				'menu-item-url'       => ! empty( $item['url'] ) ? (string) $item['url'] : '#',
				'menu-item-status'    => 'publish',
				'menu-item-parent-id' => $parent_id,
			]
		);

		if ( is_wp_error( $item_id ) || empty( $item['children'] ) || ! is_array( $item['children'] ) ) {
			continue;
		}

		ca_seed_nav_menu_items( $menu_id, $item['children'], (int) $item_id );
	}
}

/**
 * Curate block inserter list for a page-builder-like editing experience.
 *
