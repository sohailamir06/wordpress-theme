<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function ca_render_site_header() {
	$base = trailingslashit( home_url() );

	$hvac = [
		[ 'AC Repair',         'services/ac-repair/' ],
		[ 'AC Installation',   'services/ac-install/' ],
		[ 'AC Maintenance',    'services/ac-maintenance/' ],
		[ 'Commercial HVAC',   'services/commercial/' ],
		[ 'Emergency Service', 'services/emergency/' ],
	];
	$ducts = [
		[ 'Duct Cleaning',     'services/duct-cleaning/' ],
		[ 'Duct Repair',       'services/duct-repair/' ],
		[ 'Duct Installation', 'services/duct-install/' ],
	];
	$air = [
		[ 'UV Lights',     'services/uv-lights/' ],
		[ 'Air Purifiers', 'services/air-purifiers/' ],
		[ 'Air Filters',   'services/air-filters/' ],
		[ 'Thermostats',   'services/thermostats/' ],
	];
	$areas = [
		[ 'Miami-Dade County',   'service-areas/' ],
		[ 'Broward County',      'service-areas/' ],
		[ 'Palm Beach County',   'service-areas/' ],
		[ '→ All Service Areas', 'service-areas/' ],
	];
	$about = [
		[ 'About Us',          'about/' ],
		[ 'Financing',         'financing/' ],
		[ 'Careers',           'careers/' ],
		[ 'Specials & Deals',  'specials/' ],
		[ 'Brands We Service', 'brands/' ],
	];

	ob_start(); ?>
	<div class="nav-wrapper" data-site-header>
		<div class="ebar">
			<span class="ebar-item live"><span class="live-dot"></span>24/7/365 · Real People in our Office</span>
			<span class="ebar-item rating">South Florida's Highest Rated <span class="rating-stars">★★★★★</span> 4.9 · 4,600+ Reviews</span>
			<a class="ebar-item ebar-call" href="tel:<?php echo CA_PHONE_RAW; ?>">📞 Call or Text <?php echo CA_PHONE; ?> <span class="ebar-pill">Open Now</span></a>
			<span class="ebar-item">A+ BBB · Licensed &amp; Insured · Family Owned &amp; Operated</span>
		</div>
		<nav class="nav" aria-label="Main">
			<div class="nav-inner">
				<a class="nav-logo" href="<?php echo esc_url( $base ); ?>">
					<img src="<?php echo CA_THEME_URI; ?>/assets/images/logo4t.png" alt="Cool Air USA">
				</a>
				<div class="nav-links">
					<?php echo ca_nav_dropdown( 'hvac',  'HVAC',          $hvac,  $base ); ?>
					<?php echo ca_nav_dropdown( 'ducts', 'Duct Services', $ducts, $base ); ?>
					<?php echo ca_nav_dropdown( 'air',   'Air Quality',   $air,   $base ); ?>
					<a class="nav-btn" href="<?php echo esc_url( $base ); ?>services/plumbing/">Plumbing</a>
					<a class="nav-btn" href="<?php echo esc_url( $base ); ?>membership/">Membership</a>
					<?php echo ca_nav_dropdown( 'areas', 'Service Areas', $areas, $base ); ?>
					<?php echo ca_nav_dropdown( 'about', 'About',         $about, $base ); ?>
					<a class="nav-btn" href="<?php echo esc_url( $base ); ?>contact/">Contact</a>
				</div>
				<div class="nav-actions">
					<a class="nav-phone" href="tel:<?php echo CA_PHONE_RAW; ?>"><?php echo CA_PHONE; ?></a>
					<a class="btn-portal" href="<?php echo esc_url( CA_PORTAL ); ?>" target="_blank" rel="noopener">Customer Portal</a>
				</div>
				<button class="nav-hamburger" aria-label="Menu" data-mobile-toggle><span></span><span></span><span></span></button>
			</div>
			<?php echo ca_nav_mobile( $base, $hvac, $ducts, $air ); ?>
		</nav>
	</div>
	<?php
	return ob_get_clean();
}

function ca_nav_dropdown( $id, $label, $items, $base ) {
	ob_start(); ?>
	<div class="nav-item" data-dropdown="<?php echo esc_attr( $id ); ?>">
		<button class="nav-btn" type="button"><?php echo esc_html( $label ); ?> <span class="nav-chevron">▾</span></button>
		<div class="nav-dropdown">
			<?php foreach ( $items as $item ) : ?>
				<a class="nav-dd-item" href="<?php echo esc_url( $base . $item[1] ); ?>"><?php echo esc_html( $item[0] ); ?></a>
			<?php endforeach; ?>
		</div>
	</div>
	<?php
	return ob_get_clean();
}

function ca_nav_mobile( $base, $hvac, $ducts, $air ) {
	ob_start(); ?>
	<div class="mobile-menu" data-mobile-menu>
		<span class="mob-label">HVAC Services</span>
		<?php foreach ( $hvac as $i ) : ?><a class="mob-btn" href="<?php echo esc_url( $base . $i[1] ); ?>"><?php echo esc_html( $i[0] ); ?></a><?php endforeach; ?>
		<span class="mob-label">Duct Services</span>
		<?php foreach ( $ducts as $i ) : ?><a class="mob-btn" href="<?php echo esc_url( $base . $i[1] ); ?>"><?php echo esc_html( $i[0] ); ?></a><?php endforeach; ?>
		<span class="mob-label">Air Quality</span>
		<?php foreach ( $air as $i ) : ?><a class="mob-btn" href="<?php echo esc_url( $base . $i[1] ); ?>"><?php echo esc_html( $i[0] ); ?></a><?php endforeach; ?>
		<span class="mob-label">More</span>
		<a class="mob-btn" href="<?php echo esc_url( $base ); ?>services/plumbing/">Plumbing</a>
		<a class="mob-btn" href="<?php echo esc_url( $base ); ?>membership/">Membership</a>
		<a class="mob-btn" href="<?php echo esc_url( $base ); ?>service-areas/">Service Areas</a>
		<a class="mob-btn" href="<?php echo esc_url( $base ); ?>contact/">Contact Us</a>
		<a class="mob-btn" href="<?php echo esc_url( $base ); ?>about/">About Us</a>
	</div>
	<?php
	return ob_get_clean();
}
