<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Resolve core/pattern references into full block markup for front page editing.
 *
 * @param int    $post_id Page ID.
 * @param string $path    Blueprint page path.
 * @return void
 */
function ca_expand_front_page_pattern_references( $post_id, $path ) {
	if ( 'home' !== $path ) {
		return;
	}

	$post = get_post( $post_id );
	if ( ! $post || 'page' !== $post->post_type ) {
		return;
	}

	$content = trim( (string) $post->post_content );
	if ( '' === $content || false === strpos( $content, '<!-- wp:pattern' ) ) {
		return;
	}
	if ( ! function_exists( 'parse_blocks' ) || ! function_exists( 'serialize_blocks' ) || ! function_exists( 'resolve_pattern_blocks' ) ) {
		return;
	}

	$blocks = parse_blocks( $content );
	if ( empty( $blocks ) ) {
		return;
	}

	$resolved = resolve_pattern_blocks( $blocks );
	$updated  = trim( serialize_blocks( $resolved ) );

	if ( '' === $updated || $updated === $content ) {
		return;
	}

	wp_update_post(
		[
			'ID'           => $post_id,
			'post_content' => $updated,
		]
	);
}

/**
 * Upgrade legacy or malformed home hero markup to the screenshot-matched v2 pattern.
 *
 * @param int    $post_id Page ID.
 * @param string $path    Blueprint page path.
 * @return void
 */
function ca_refresh_legacy_home_hero_section( $post_id, $path ) {
	if ( 'home' !== $path ) {
		return;
	}

	$post = get_post( $post_id );
	if ( ! $post || 'page' !== $post->post_type ) {
		return;
	}

	$content = trim( (string) $post->post_content );
	if ( '' === $content ) {
		return;
	}
	if ( ! function_exists( 'parse_blocks' ) || ! function_exists( 'serialize_blocks' ) ) {
		return;
	}

	$blocks = parse_blocks( $content );
	if ( empty( $blocks ) ) {
		return;
	}

	$hero_markup = '';
	$hero_file   = trailingslashit( CA_THEME_DIR ) . 'patterns/home-hero.php';
	if ( is_readable( $hero_file ) ) {
		ob_start();
		include $hero_file;
		$hero_markup = trim( (string) ob_get_clean() );
	}
	if ( '' === $hero_markup ) {
		return;
	}

	$hero_pattern_blocks = parse_blocks( $hero_markup );
	if ( empty( $hero_pattern_blocks[0] ) || ! is_array( $hero_pattern_blocks[0] ) ) {
		return;
	}

	$hero_block = $hero_pattern_blocks[0];
	$updated    = false;

	$replace_hero = static function ( array &$items ) use ( &$replace_hero, $hero_block, &$updated ) {
		foreach ( $items as $index => &$block ) {
			if ( ! is_array( $block ) ) {
				continue;
			}

			$attrs      = isset( $block['attrs'] ) && is_array( $block['attrs'] ) ? $block['attrs'] : [];
			$class_name = isset( $attrs['className'] ) ? (string) $attrs['className'] : '';
			$pattern    = '';
			if ( isset( $attrs['metadata'] ) && is_array( $attrs['metadata'] ) ) {
				$pattern = isset( $attrs['metadata']['patternName'] ) ? (string) $attrs['metadata']['patternName'] : '';
			}

			$is_hero_block = false !== strpos( ' ' . $class_name . ' ', ' hero ' ) || 'cool-air-usa/home-hero' === $pattern;
			if ( $is_hero_block ) {
				$serialized = serialize_blocks( [ $block ] );
				$is_current = false !== strpos( $serialized, 'hero-v2' )
					&& false !== strpos( $serialized, '4,760+ Reviews' )
					&& false !== strpos( $serialized, 'You Can<br>Trust' );

				if ( ! $is_current ) {
					$items[ $index ] = $hero_block;
					$updated         = true;
				}

				return;
			}

			if ( ! empty( $block['innerBlocks'] ) && is_array( $block['innerBlocks'] ) ) {
				$replace_hero( $block['innerBlocks'] );
				if ( $updated ) {
					return;
				}
			}
		}
	};

	$replace_hero( $blocks );

	if ( ! $updated ) {
		return;
	}

	$new_content = trim( serialize_blocks( $blocks ) );
	if ( '' === $new_content || $new_content === $content ) {
		return;
	}

	wp_update_post(
		[
			'ID'           => $post_id,
			'post_content' => $new_content,
		]
	);
}

/**
 * Upgrade legacy 3-card home gallery block to the editable 12-card slider layout.
 *
 * @param int    $post_id Page ID.
 * @param string $path    Blueprint page path.
 * @return void
 */
function ca_refresh_legacy_home_gallery_section( $post_id, $path ) {
	if ( 'home' !== $path ) {
		return;
	}

	$post = get_post( $post_id );
	if ( ! $post || 'page' !== $post->post_type ) {
		return;
	}

	$content = trim( (string) $post->post_content );
	if ( '' === $content ) {
		return;
	}
	if ( ! function_exists( 'parse_blocks' ) || ! function_exists( 'serialize_blocks' ) || ! function_exists( 'resolve_pattern_blocks' ) ) {
		return;
	}

	$blocks = parse_blocks( $content );
	if ( empty( $blocks ) ) {
		return;
	}

	$gallery_markup = '';
	$gallery_file   = trailingslashit( CA_THEME_DIR ) . 'patterns/home-gallery.php';
	if ( is_readable( $gallery_file ) ) {
		ob_start();
		include $gallery_file;
		$gallery_markup = trim( (string) ob_get_clean() );
	}
	if ( '' === $gallery_markup ) {
		return;
	}

	$gallery_pattern_blocks = parse_blocks( $gallery_markup );
	if ( empty( $gallery_pattern_blocks[0] ) || ! is_array( $gallery_pattern_blocks[0] ) ) {
		return;
	}

	$gallery_block = $gallery_pattern_blocks[0];
	$updated       = false;

	$replace_gallery = static function ( array &$items ) use ( &$replace_gallery, $gallery_block, &$updated ) {
		foreach ( $items as $index => &$block ) {
			if ( ! is_array( $block ) ) {
				continue;
			}

			$attrs      = isset( $block['attrs'] ) && is_array( $block['attrs'] ) ? $block['attrs'] : [];
			$class_name = isset( $attrs['className'] ) ? (string) $attrs['className'] : '';
			$pattern    = '';
			if ( isset( $attrs['metadata'] ) && is_array( $attrs['metadata'] ) ) {
				$pattern = isset( $attrs['metadata']['patternName'] ) ? (string) $attrs['metadata']['patternName'] : '';
			}

			$is_gallery_block = false !== strpos( $class_name, 'gallery-section' ) || 'cool-air-usa/home-gallery' === $pattern;
			if ( $is_gallery_block ) {
				$serialized = serialize_blocks( [ $block ] );
				$is_current = false !== strpos( $serialized, 'data-gallery-autoplay' )
					&& false !== strpos( $serialized, 'gallery-toggle' )
					&& false !== strpos( $serialized, '5-Ton Carrier Swap' );

				if ( ! $is_current ) {
					$items[ $index ] = $gallery_block;
					$updated         = true;
				}

				return;
			}

			if ( ! empty( $block['innerBlocks'] ) && is_array( $block['innerBlocks'] ) ) {
				$replace_gallery( $block['innerBlocks'] );
				if ( $updated ) {
					return;
				}
			}
		}
	};

	$replace_gallery( $blocks );

	if ( ! $updated ) {
		return;
	}

	$new_content = trim( serialize_blocks( $blocks ) );
	if ( '' === $new_content || $new_content === $content ) {
		return;
	}

	wp_update_post(
		[
			'ID'           => $post_id,
			'post_content' => $new_content,
		]
	);
}

/**
 * Upgrade legacy home stats section markup to latest editable slider structure.
 *
 * @param int    $post_id Page ID.
 * @param string $path    Blueprint page path.
 * @return void
 */
function ca_refresh_legacy_home_stats_section( $post_id, $path ) {
	if ( 'home' !== $path ) {
		return;
	}

	$post = get_post( $post_id );
	if ( ! $post || 'page' !== $post->post_type ) {
		return;
	}

	$content = trim( (string) $post->post_content );
	if ( '' === $content || false !== strpos( $content, 'stats-start-' ) ) {
		return;
	}
	if ( ! function_exists( 'parse_blocks' ) || ! function_exists( 'serialize_blocks' ) ) {
		return;
	}

	$blocks = parse_blocks( $content );
	if ( empty( $blocks ) ) {
		return;
	}

	$stats_markup = '';
	$stats_file   = trailingslashit( CA_THEME_DIR ) . 'patterns/home-stats-bar.php';
	if ( is_readable( $stats_file ) ) {
		ob_start();
		include $stats_file;
		$stats_markup = trim( (string) ob_get_clean() );
	}
	if ( '' === $stats_markup ) {
		return;
	}

	$stats_pattern_blocks = parse_blocks( $stats_markup );
	if ( empty( $stats_pattern_blocks[0] ) || ! is_array( $stats_pattern_blocks[0] ) ) {
		return;
	}
	$stats_block = $stats_pattern_blocks[0];
	$updated     = false;

	foreach ( $blocks as $index => $block ) {
		if ( empty( $block['blockName'] ) || 'core/group' !== $block['blockName'] ) {
			continue;
		}
		$class_name = isset( $block['attrs']['className'] ) ? (string) $block['attrs']['className'] : '';
		if ( false === strpos( $class_name, 'stats-bar' ) ) {
			continue;
		}

		$blocks[ $index ] = $stats_block;
		$updated          = true;
		break;
	}

	if ( ! $updated ) {
		return;
	}

	$new_content = trim( serialize_blocks( $blocks ) );
	if ( '' === $new_content || $new_content === $content ) {
		return;
	}

	wp_update_post(
		[
			'ID'           => $post_id,
			'post_content' => $new_content,
		]
	);
}

/**
 * Upgrade legacy home reviews section markup to latest editable block structure.
 *
 * @param int    $post_id Page ID.
 * @param string $path    Blueprint page path.
 * @return void
 */
function ca_refresh_legacy_home_reviews_section( $post_id, $path ) {
	if ( 'home' !== $path ) {
		return;
	}

	$post = get_post( $post_id );
	if ( ! $post || 'page' !== $post->post_type ) {
		return;
	}

	$content = trim( (string) $post->post_content );
	if ( '' === $content ) {
		return;
	}
	if ( ! function_exists( 'parse_blocks' ) || ! function_exists( 'serialize_blocks' ) ) {
		return;
	}

	$blocks = parse_blocks( $content );
	if ( empty( $blocks ) ) {
		return;
	}

	$reviews_markup = '';
	$reviews_file   = trailingslashit( CA_THEME_DIR ) . 'patterns/home-reviews.php';
	if ( is_readable( $reviews_file ) ) {
		ob_start();
		include $reviews_file;
		$reviews_markup = trim( (string) ob_get_clean() );
	}
	if ( '' === $reviews_markup ) {
		return;
	}

	$reviews_pattern_blocks = parse_blocks( $reviews_markup );
	if ( empty( $reviews_pattern_blocks[0] ) || ! is_array( $reviews_pattern_blocks[0] ) ) {
		return;
	}
	$reviews_block = $reviews_pattern_blocks[0];
	$updated       = false;

	foreach ( $blocks as $index => $block ) {
		if ( empty( $block['blockName'] ) || 'core/group' !== $block['blockName'] ) {
			continue;
		}
		$class_name = isset( $block['attrs']['className'] ) ? (string) $block['attrs']['className'] : '';
		if ( false === strpos( $class_name, 'reviews-section' ) ) {
			continue;
		}

		$serialized = serialize_blocks( [ $block ] );
		$is_current = false !== strpos( $serialized, 'reviews-tags-lead' )
			&& false !== strpos( $serialized, 'reviews-google-mark' )
			&& false !== strpos( $serialized, 'reviews-dist-row' )
			&& false !== strpos( $serialized, 'section reviews-section' );
		if ( $is_current ) {
			return;
		}

		$blocks[ $index ] = $reviews_block;
		$updated          = true;
		break;
	}

	if ( ! $updated ) {
		return;
	}

	$new_content = trim( serialize_blocks( $blocks ) );
	if ( '' === $new_content || $new_content === $content ) {
		return;
	}

	wp_update_post(
		[
			'ID'           => $post_id,
			'post_content' => $new_content,
		]
	);
}

/**
 * Upgrade legacy home process section to latest editable v3 block structure.
 *
 * @param int    $post_id Page ID.
 * @param string $path    Blueprint page path.
 * @return void
 */
function ca_refresh_legacy_home_process_section( $post_id, $path ) {
	if ( 'home' !== $path ) {
		return;
	}

	$post = get_post( $post_id );
	if ( ! $post || 'page' !== $post->post_type ) {
		return;
	}

	$content = trim( (string) $post->post_content );
	if ( '' === $content ) {
		return;
	}
	if ( ! function_exists( 'parse_blocks' ) || ! function_exists( 'serialize_blocks' ) ) {
		return;
	}

	$blocks = parse_blocks( $content );
	if ( empty( $blocks ) ) {
		return;
	}

	$process_markup = '';
	$process_file   = trailingslashit( CA_THEME_DIR ) . 'patterns/home-process.php';
	if ( is_readable( $process_file ) ) {
		ob_start();
		include $process_file;
		$process_markup = trim( (string) ob_get_clean() );
	}
	if ( '' === $process_markup ) {
		return;
	}

	$process_pattern_blocks = parse_blocks( $process_markup );
	if ( empty( $process_pattern_blocks[0] ) || ! is_array( $process_pattern_blocks[0] ) ) {
		return;
	}
	$process_block = $process_pattern_blocks[0];
	$updated       = false;

	foreach ( $blocks as $index => $block ) {
		if ( empty( $block['blockName'] ) || 'core/group' !== $block['blockName'] ) {
			continue;
		}
		$class_name = isset( $block['attrs']['className'] ) ? (string) $block['attrs']['className'] : '';
		if ( false === strpos( $class_name, 'process-section' ) && false === strpos( $class_name, 'proc-section' ) ) {
			continue;
		}

		$serialized = serialize_blocks( [ $block ] );
		$is_current = false !== strpos( $serialized, 'process-v3' )
			&& false !== strpos( $serialized, 'id="process"' )
			&& false !== strpos( $serialized, 'data-process-start="1"' )
			&& false !== strpos( $serialized, 'process-road-dashed' );
		if ( $is_current ) {
			return;
		}

		$blocks[ $index ] = $process_block;
		$updated          = true;
		break;
	}

	if ( ! $updated ) {
		return;
	}

	$new_content = trim( serialize_blocks( $blocks ) );
	if ( '' === $new_content || $new_content === $content ) {
		return;
	}

	wp_update_post(
		[
			'ID'           => $post_id,
			'post_content' => $new_content,
		]
	);
}

/**
 * Upgrade legacy home brands section to latest editable v2 block structure.
 *
 * @param int    $post_id Page ID.
 * @param string $path    Blueprint page path.
 * @return void
 */
function ca_refresh_legacy_home_brands_section( $post_id, $path ) {
	if ( 'home' !== $path ) {
		return;
	}

	$post = get_post( $post_id );
	if ( ! $post || 'page' !== $post->post_type ) {
		return;
	}

	$content = trim( (string) $post->post_content );
	if ( '' === $content ) {
		return;
	}
	if ( ! function_exists( 'parse_blocks' ) || ! function_exists( 'serialize_blocks' ) ) {
		return;
	}

	$blocks = parse_blocks( $content );
	if ( empty( $blocks ) ) {
		return;
	}

	$brands_markup = '';
	$brands_file   = trailingslashit( CA_THEME_DIR ) . 'patterns/home-brands.php';
	if ( is_readable( $brands_file ) ) {
		ob_start();
		include $brands_file;
		$brands_markup = trim( (string) ob_get_clean() );
	}
	if ( '' === $brands_markup ) {
		return;
	}

	$brands_pattern_blocks = parse_blocks( $brands_markup );
	if ( empty( $brands_pattern_blocks[0] ) || ! is_array( $brands_pattern_blocks[0] ) ) {
		return;
	}
	$brands_block = $brands_pattern_blocks[0];
	$updated      = false;

	foreach ( $blocks as $index => $block ) {
		if ( empty( $block['blockName'] ) || 'core/group' !== $block['blockName'] ) {
			continue;
		}
		$class_name = isset( $block['attrs']['className'] ) ? (string) $block['attrs']['className'] : '';
		if ( false === strpos( $class_name, 'brands-section' ) ) {
			continue;
		}

		$serialized = serialize_blocks( [ $block ] );
		$is_current = false !== strpos( $serialized, 'brands-static-v2' )
			&& false !== strpos( $serialized, 'ClimateMaster' )
			&& false !== strpos( $serialized, 'Honeywell' );
		if ( $is_current ) {
			return;
		}

		$blocks[ $index ] = $brands_block;
		$updated          = true;
		break;
	}

	if ( ! $updated ) {
		return;
	}

	$new_content = trim( serialize_blocks( $blocks ) );
	if ( '' === $new_content || $new_content === $content ) {
		return;
	}

	wp_update_post(
		[
			'ID'           => $post_id,
			'post_content' => $new_content,
		]
	);
}
