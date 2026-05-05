<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function ca_render_site_header() {
	$menu_items = ca_get_primary_menu_items();

	ob_start(); ?>
	<div class="nav-wrapper" data-site-header>
		<div class="ebar">
			<span class="ebar-item live"><span class="live-dot"></span>24/7/365 - Real People in our Office</span>
			<span class="ebar-item rating">South Florida's Highest Rated <span class="rating-stars">*****</span> 4.9 - 4,600+ Reviews</span>
			<a class="ebar-item ebar-call" href="tel:<?php echo esc_attr( CA_PHONE_RAW ); ?>">Call or Text <?php echo esc_html( CA_PHONE ); ?> <span class="ebar-pill">Open Now</span></a>
			<span class="ebar-item">A+ BBB - Licensed &amp; Insured - Family Owned &amp; Operated</span>
		</div>
		<nav class="nav" aria-label="<?php esc_attr_e( 'Main', 'cool-air-usa' ); ?>">
			<div class="nav-inner">
				<a class="nav-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
					<img src="<?php echo esc_url( CA_THEME_URI . '/assets/images/logo4t.png' ); ?>" alt="<?php esc_attr_e( 'Cool Air USA', 'cool-air-usa' ); ?>">
				</a>
				<div class="nav-links">
					<?php echo ca_render_desktop_menu_items( $menu_items ); ?>
				</div>
				<div class="nav-actions">
					<a class="nav-phone" href="tel:<?php echo esc_attr( CA_PHONE_RAW ); ?>"><?php echo esc_html( CA_PHONE ); ?></a>
					<a class="btn-portal" href="<?php echo esc_url( CA_PORTAL ); ?>" target="_blank" rel="noopener">Customer Portal</a>
				</div>
				<button class="nav-hamburger" type="button" aria-label="<?php esc_attr_e( 'Menu', 'cool-air-usa' ); ?>" data-mobile-toggle><span></span><span></span><span></span></button>
			</div>
			<?php echo ca_render_mobile_menu_items( $menu_items ); ?>
		</nav>
	</div>
	<?php
	return ob_get_clean();
}

function ca_default_primary_menu_items() {
	return [
		[
			'title'    => 'HVAC',
			'url'      => '#',
			'children' => [
				[ 'title' => 'AC Repair',         'url' => home_url( '/services/ac-repair/' ) ],
				[ 'title' => 'AC Installation',   'url' => home_url( '/services/ac-install/' ) ],
				[ 'title' => 'AC Maintenance',    'url' => home_url( '/services/ac-maintenance/' ) ],
				[ 'title' => 'Commercial HVAC',   'url' => home_url( '/services/commercial/' ) ],
				[ 'title' => 'Emergency Service', 'url' => home_url( '/services/emergency/' ) ],
			],
		],
		[
			'title'    => 'Duct Services',
			'url'      => '#',
			'children' => [
				[ 'title' => 'Duct Cleaning',     'url' => home_url( '/services/duct-cleaning/' ) ],
				[ 'title' => 'Duct Repair',       'url' => home_url( '/services/duct-repair/' ) ],
				[ 'title' => 'Duct Installation', 'url' => home_url( '/services/duct-install/' ) ],
			],
		],
		[
			'title'    => 'Air Quality',
			'url'      => '#',
			'children' => [
				[ 'title' => 'UV Lights',     'url' => home_url( '/services/uv-lights/' ) ],
				[ 'title' => 'Air Purifiers', 'url' => home_url( '/services/air-purifiers/' ) ],
				[ 'title' => 'Air Filters',   'url' => home_url( '/services/air-filters/' ) ],
				[ 'title' => 'Thermostats',   'url' => home_url( '/services/thermostats/' ) ],
			],
		],
		[ 'title' => 'Plumbing',   'url' => home_url( '/services/plumbing/' ) ],
		[ 'title' => 'Membership', 'url' => home_url( '/membership/' ) ],
		[
			'title'    => 'Service Areas',
			'url'      => home_url( '/service-areas/' ),
			'children' => [
				[ 'title' => 'Miami-Dade County', 'url' => home_url( '/service-areas/' ) ],
				[ 'title' => 'Broward County',    'url' => home_url( '/service-areas/' ) ],
				[ 'title' => 'Palm Beach County', 'url' => home_url( '/service-areas/' ) ],
				[ 'title' => 'All Service Areas', 'url' => home_url( '/service-areas/' ) ],
			],
		],
		[
			'title'    => 'About',
			'url'      => home_url( '/about/' ),
			'children' => [
				[ 'title' => 'About Us',          'url' => home_url( '/about/' ) ],
				[ 'title' => 'Financing',         'url' => home_url( '/financing/' ) ],
				[ 'title' => 'Careers',           'url' => home_url( '/careers/' ) ],
				[ 'title' => 'Specials & Deals',  'url' => home_url( '/specials/' ) ],
				[ 'title' => 'Brands We Service', 'url' => home_url( '/brands/' ) ],
			],
		],
		[ 'title' => 'Contact', 'url' => home_url( '/contact/' ) ],
	];
}

function ca_get_primary_menu_items() {
	if ( has_nav_menu( 'primary' ) ) {
		$locations = get_nav_menu_locations();
		$menu_id   = ! empty( $locations['primary'] ) ? (int) $locations['primary'] : 0;
		$items     = $menu_id > 0 ? wp_get_nav_menu_items( $menu_id ) : [];

		if ( ! empty( $items ) && is_array( $items ) ) {
			return ca_build_menu_tree( $items );
		}
	}

	return ca_default_primary_menu_items();
}

function ca_build_menu_tree( $items ) {
	$nodes = [];
	$children_by_parent = [];

	foreach ( $items as $item ) {
		$id        = (int) $item->ID;
		$parent_id = (int) $item->menu_item_parent;

		$nodes[ $id ] = [
			'id'        => $id,
			'parent'    => $parent_id,
			'title'     => $item->title,
			'url'       => $item->url,
			'target'    => $item->target,
			'xfn'       => $item->xfn,
			'classes'   => array_filter( (array) $item->classes ),
			'children'  => [],
		];

		$children_by_parent[ $parent_id ][] = $id;
	}

	return ca_build_menu_branch( 0, $nodes, $children_by_parent );
}

function ca_build_menu_branch( $parent_id, $nodes, $children_by_parent ) {
	$branch = [];

	if ( empty( $children_by_parent[ $parent_id ] ) ) {
		return $branch;
	}

	foreach ( $children_by_parent[ $parent_id ] as $id ) {
		if ( empty( $nodes[ $id ] ) ) {
			continue;
		}

		$node             = $nodes[ $id ];
		$node['children'] = ca_build_menu_branch( $id, $nodes, $children_by_parent );
		$branch[]         = $node;
	}

	return $branch;
}

function ca_render_desktop_menu_items( $items ) {
	ob_start();
	foreach ( $items as $index => $item ) {
		if ( ! empty( $item['children'] ) ) {
			echo ca_render_nav_dropdown( $item, $index );
			continue;
		}

		echo ca_render_nav_link( $item, 'nav-btn' );
	}
	return ob_get_clean();
}

function ca_render_nav_dropdown( $item, $index ) {
	$dropdown_id = sanitize_title( $item['title'] ) . '-' . (int) $index;

	ob_start(); ?>
	<div class="nav-item" data-dropdown="<?php echo esc_attr( $dropdown_id ); ?>">
		<button class="nav-btn<?php echo ca_menu_item_is_active( $item ) ? ' act' : ''; ?>" type="button">
			<?php echo esc_html( $item['title'] ); ?> <span class="nav-chevron">v</span>
		</button>
		<div class="nav-dropdown">
			<?php foreach ( $item['children'] as $child_index => $child ) : ?>
				<?php if ( ! empty( $child['children'] ) ) : ?>
					<?php echo ca_render_nav_submenu( $child, $child_index ); ?>
				<?php else : ?>
					<?php echo ca_render_nav_link( $child, 'nav-dd-item' ); ?>
				<?php endif; ?>
			<?php endforeach; ?>
		</div>
	</div>
	<?php
	return ob_get_clean();
}

function ca_render_nav_submenu( $item, $index ) {
	$dropdown_id = sanitize_title( $item['title'] ) . '-' . (int) $index;

	ob_start(); ?>
	<div class="nav-item has-submenu" data-dropdown="<?php echo esc_attr( $dropdown_id ); ?>">
		<button class="nav-dd-item<?php echo ca_menu_item_is_active( $item ) ? ' act' : ''; ?>" type="button">
			<?php echo esc_html( $item['title'] ); ?> <span class="nav-chevron-sub">›</span>
		</button>
		<div class="nav-dropdown submenu">
			<?php foreach ( $item['children'] as $child_index => $child ) : ?>
				<?php if ( ! empty( $child['children'] ) ) : ?>
					<?php echo ca_render_nav_submenu( $child, $child_index ); ?>
				<?php else : ?>
					<?php echo ca_render_nav_link( $child, 'nav-dd-item' ); ?>
				<?php endif; ?>
			<?php endforeach; ?>
		</div>
	</div>
	<?php
	return ob_get_clean();
}

function ca_render_mobile_menu_items( $items ) {
	ob_start(); ?>
	<div class="mobile-menu" data-mobile-menu>
		<?php foreach ( $items as $item ) : ?>
			<?php echo ca_render_mobile_menu_item( $item ); ?>
		<?php endforeach; ?>
	</div>
	<?php
	return ob_get_clean();
}

function ca_render_mobile_menu_item( $item ) {
	ob_start();

	if ( ! empty( $item['children'] ) ) {
		?>
		<span class="mob-label"><?php echo esc_html( $item['title'] ); ?></span>
		<?php if ( ! ca_is_placeholder_url( $item['url'] ) ) : ?>
			<?php echo ca_render_nav_link( [ 'title' => 'View ' . $item['title'], 'url' => $item['url'] ], 'mob-btn' ); ?>
		<?php endif; ?>
		<?php foreach ( $item['children'] as $child ) : ?>
			<?php echo ca_render_mobile_menu_item( $child ); ?>
		<?php endforeach; ?>
		<?php
		return ob_get_clean();
	}

	echo ca_render_nav_link( $item, 'mob-btn' );
	return ob_get_clean();
}

function ca_render_nav_link( $item, $class ) {
	$title  = isset( $item['title'] ) ? (string) $item['title'] : '';
	$url    = ! empty( $item['url'] ) ? (string) $item['url'] : '#';
	$class .= ca_menu_item_is_active( $item ) ? ' act' : '';

	$target = ! empty( $item['target'] ) ? (string) $item['target'] : '';
	$xfn    = ! empty( $item['xfn'] ) ? (string) $item['xfn'] : '';
	$rel    = trim( $xfn . ( '_blank' === $target ? ' noopener' : '' ) );

	ob_start(); ?>
	<a class="<?php echo esc_attr( $class ); ?>" href="<?php echo esc_url( $url ); ?>"<?php echo $target ? ' target="' . esc_attr( $target ) . '"' : ''; ?><?php echo $rel ? ' rel="' . esc_attr( $rel ) . '"' : ''; ?>>
		<?php echo esc_html( $title ); ?>
	</a>
	<?php
	return ob_get_clean();
}

function ca_menu_item_is_active( $item ) {
	$classes = ! empty( $item['classes'] ) ? (array) $item['classes'] : [];

	foreach ( [ 'current-menu-item', 'current-menu-parent', 'current-menu-ancestor', 'current_page_item' ] as $class ) {
		if ( in_array( $class, $classes, true ) ) {
			return true;
		}
	}

	return false;
}

function ca_is_placeholder_url( $url ) {
	$url = trim( (string) $url );
	return '' === $url || '#' === $url;
}
