<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function ca_render_site_footer() {
	$footer_menus = ca_default_footer_menus();

	ob_start(); ?>
	<footer class="footer">
		<div class="footer-main">
			<div class="footer-col-brand">
				<div class="footer-logo"><img src="<?php echo esc_url( CA_THEME_URI . '/assets/images/logo4t.png' ); ?>" alt="<?php esc_attr_e( 'Cool Air USA', 'cool-air-usa' ); ?>"></div>
				<div class="footer-tagline">We Care About Your Air</div>
				<p class="footer-about">Family-owned and operated since 2009. South Florida's most trusted HVAC contractor serving over 250,000 lifetime customers across Miami-Dade, Broward, and Palm Beach counties.</p>
				<div class="footer-crow">Phone: <a href="tel:<?php echo esc_attr( CA_PHONE_RAW ); ?>"><?php echo esc_html( CA_PHONE ); ?></a></div>
				<div class="footer-crow">Email: <a href="mailto:<?php echo esc_attr( CA_EMAIL ); ?>"><?php echo esc_html( CA_EMAIL ); ?></a></div>
				<div class="footer-crow">Address: <?php echo esc_html( CA_ADDRESS ); ?></div>
				<div class="footer-crow">Office: 7am-9pm - Emergency: 24/7/365</div>
			</div>

			<?php foreach ( [ 'footer_hvac', 'footer_more', 'footer_company' ] as $location ) : ?>
				<?php $config = isset( $footer_menus[ $location ] ) ? $footer_menus[ $location ] : []; ?>
				<div>
					<div class="fcol-title"><?php echo esc_html( isset( $config['title'] ) ? $config['title'] : '' ); ?></div>
					<?php echo ca_render_footer_menu_links( $location, isset( $config['items'] ) ? $config['items'] : [] ); ?>
				</div>
			<?php endforeach; ?>
		</div>

		<div class="footer-bot">
			<div class="footer-bot-copy">Copyright <?php echo esc_html( ca_year() ); ?> Cool Air USA. All rights reserved. | CAC1816920</div>
			<div class="footer-legal-links">
				<?php echo ca_render_footer_legal_links(); ?>
			</div>
			<div class="fbadges">
				<span class="fbadge">4.9 Google</span>
				<span class="fbadge">A+ BBB</span>
				<span class="fbadge">Licensed &amp; Insured</span>
				<span class="fbadge">Family Owned &amp; Operated</span>
			</div>
		</div>
	</footer>
	<?php
	return ob_get_clean();
}

function ca_default_footer_menus() {
	return [
		'footer_hvac' => [
			'name'  => 'Footer HVAC Services',
			'title' => 'HVAC Services',
			'items' => [
				[ 'title' => 'AC Repair',         'url' => home_url( '/services/ac-repair/' ) ],
				[ 'title' => 'AC Installation',   'url' => home_url( '/services/ac-install/' ) ],
				[ 'title' => 'AC Maintenance',    'url' => home_url( '/services/ac-maintenance/' ) ],
				[ 'title' => 'Commercial HVAC',   'url' => home_url( '/services/commercial/' ) ],
				[ 'title' => 'Emergency Service', 'url' => home_url( '/services/emergency/' ) ],
			],
		],
		'footer_more' => [
			'name'  => 'Footer More Services',
			'title' => 'More Services',
			'items' => [
				[ 'title' => 'Duct Cleaning', 'url' => home_url( '/services/duct-cleaning/' ) ],
				[ 'title' => 'Duct Repair',   'url' => home_url( '/services/duct-repair/' ) ],
				[ 'title' => 'UV Lights',     'url' => home_url( '/services/uv-lights/' ) ],
				[ 'title' => 'Air Purifiers', 'url' => home_url( '/services/air-purifiers/' ) ],
				[ 'title' => 'Thermostats',   'url' => home_url( '/services/thermostats/' ) ],
				[ 'title' => 'Plumbing',      'url' => home_url( '/services/plumbing/' ) ],
			],
		],
		'footer_company' => [
			'name'  => 'Footer Company',
			'title' => 'Company',
			'items' => [
				[ 'title' => 'About Us',          'url' => home_url( '/about/' ) ],
				[ 'title' => 'Membership Plans',  'url' => home_url( '/membership/' ) ],
				[ 'title' => 'Service Areas',     'url' => home_url( '/service-areas/' ) ],
				[ 'title' => 'Financing',         'url' => home_url( '/financing/' ) ],
				[ 'title' => 'Careers',           'url' => home_url( '/careers/' ) ],
				[ 'title' => 'Specials & Deals',  'url' => home_url( '/specials/' ) ],
				[ 'title' => 'Contact Us',        'url' => home_url( '/contact/' ) ],
				[ 'title' => 'Brands We Service', 'url' => home_url( '/brands/' ) ],
			],
		],
		'footer_legal' => [
			'name'  => 'Footer Legal',
			'title' => 'Legal',
			'items' => [
				[ 'title' => 'Privacy Policy',   'url' => home_url( '/privacy-policy/' ) ],
				[ 'title' => 'Terms of Service', 'url' => home_url( '/terms-of-service/' ) ],
				[ 'title' => 'Contact',          'url' => home_url( '/contact/' ) ],
			],
		],
	];
}

function ca_get_footer_menu_items( $location, $fallback_items = [] ) {
	if ( has_nav_menu( $location ) ) {
		$locations = get_nav_menu_locations();
		$menu_id   = ! empty( $locations[ $location ] ) ? (int) $locations[ $location ] : 0;
		$items     = $menu_id > 0 ? wp_get_nav_menu_items( $menu_id ) : [];

		if ( ! empty( $items ) && is_array( $items ) && function_exists( 'ca_build_menu_tree' ) ) {
			return ca_build_menu_tree( $items );
		}
	}

	return $fallback_items;
}

function ca_render_footer_menu_links( $location, $fallback_items = [] ) {
	$items = ca_flatten_footer_menu_items( ca_get_footer_menu_items( $location, $fallback_items ) );

	ob_start();
	foreach ( $items as $item ) {
		echo ca_render_footer_link( $item, 'flink' );
	}
	return ob_get_clean();
}

function ca_render_footer_legal_links() {
	$config = ca_default_footer_menus();
	$items  = ca_flatten_footer_menu_items( ca_get_footer_menu_items( 'footer_legal', $config['footer_legal']['items'] ) );

	ob_start();
	foreach ( $items as $index => $item ) {
		if ( $index > 0 ) {
			echo '<span class="footer-legal-sep">.</span>';
		}
		echo ca_render_footer_link( $item, 'footer-legal-link' );
	}
	return ob_get_clean();
}

function ca_flatten_footer_menu_items( $items ) {
	$flat = [];

	foreach ( $items as $item ) {
		$flat[] = $item;
		if ( ! empty( $item['children'] ) && is_array( $item['children'] ) ) {
			$flat = array_merge( $flat, ca_flatten_footer_menu_items( $item['children'] ) );
		}
	}

	return $flat;
}

function ca_render_footer_link( $item, $class ) {
	if ( function_exists( 'ca_render_nav_link' ) ) {
		return ca_render_nav_link( $item, $class );
	}

	$title = isset( $item['title'] ) ? (string) $item['title'] : '';
	$url   = ! empty( $item['url'] ) ? (string) $item['url'] : '#';

	return sprintf(
		'<a class="%1$s" href="%2$s">%3$s</a>',
		esc_attr( $class ),
		esc_url( $url ),
		esc_html( $title )
	);
}
