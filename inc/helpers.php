<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
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
 * Determine which service slug applies to current page.
 * Falls back to 'ac-repair' if no match.
 */
function ca_current_service_slug() {
	$post_slug = get_post_field( 'post_name', get_queried_object_id() );
	$slugs     = array_keys( ca_service_data() );
	if ( in_array( $post_slug, $slugs, true ) ) {
		return $post_slug;
	}

	$qs = isset( $_GET['service'] ) ? sanitize_title( wp_unslash( $_GET['service'] ) ) : '';
	if ( $qs && in_array( $qs, $slugs, true ) ) {
		return $qs;
	}

	return 'ac-repair';
}

/**
 * Helper for "current year".
 */
function ca_year() {
	return gmdate( 'Y' );
}
