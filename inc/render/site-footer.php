<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function ca_render_site_footer() {
	$base = trailingslashit( home_url() );
	$hvac_links = [
		[ 'AC Repair',         'services/ac-repair/' ],
		[ 'AC Installation',   'services/ac-install/' ],
		[ 'AC Maintenance',    'services/ac-maintenance/' ],
		[ 'Commercial HVAC',   'services/commercial/' ],
		[ 'Emergency Service', 'services/emergency/' ],
	];
	$more_links = [
		[ 'Duct Cleaning',  'services/duct-cleaning/' ],
		[ 'Duct Repair',    'services/duct-repair/' ],
		[ 'UV Lights',      'services/uv-lights/' ],
		[ 'Air Purifiers',  'services/air-purifiers/' ],
		[ 'Thermostats',    'services/thermostats/' ],
		[ 'Plumbing',       'services/plumbing/' ],
	];
	$company_links = [
		[ 'About Us',          'about/' ],
		[ 'Membership Plans',  'membership/' ],
		[ 'Service Areas',     'service-areas/' ],
		[ 'Financing',         'financing/' ],
		[ 'Careers',           'careers/' ],
		[ 'Specials & Deals',  'specials/' ],
		[ 'Contact Us',        'contact/' ],
		[ 'Brands We Service', 'brands/' ],
	];
	ob_start(); ?>
	<footer class="footer">
		<div class="footer-main">
			<div class="footer-col-brand">
				<div class="footer-logo"><img src="<?php echo CA_THEME_URI; ?>/assets/images/logo4t.png" alt="Cool Air USA"></div>
				<div class="footer-tagline">We Care About Your Air</div>
				<p class="footer-about">Family-owned and operated since 2009. South Florida's most trusted HVAC contractor serving over 250,000 lifetime customers across Miami-Dade, Broward, and Palm Beach counties.</p>
				<div class="footer-crow">📞 <a href="tel:<?php echo CA_PHONE_RAW; ?>"><?php echo CA_PHONE; ?></a></div>
				<div class="footer-crow">✉️ <a href="mailto:<?php echo esc_attr( CA_EMAIL ); ?>"><?php echo esc_html( CA_EMAIL ); ?></a></div>
				<div class="footer-crow">📍 <?php echo esc_html( CA_ADDRESS ); ?></div>
				<div class="footer-crow">🕐 Office: 7am–9pm · Emergency: 24/7/365</div>
			</div>
			<div>
				<div class="fcol-title">HVAC Services</div>
				<?php foreach ( $hvac_links as $l ) : ?>
					<a class="flink" href="<?php echo esc_url( $base . $l[1] ); ?>"><?php echo esc_html( $l[0] ); ?></a>
				<?php endforeach; ?>
			</div>
			<div>
				<div class="fcol-title">More Services</div>
				<?php foreach ( $more_links as $l ) : ?>
					<a class="flink" href="<?php echo esc_url( $base . $l[1] ); ?>"><?php echo esc_html( $l[0] ); ?></a>
				<?php endforeach; ?>
			</div>
			<div>
				<div class="fcol-title">Company</div>
				<?php foreach ( $company_links as $l ) : ?>
					<a class="flink" href="<?php echo esc_url( $base . $l[1] ); ?>"><?php echo esc_html( $l[0] ); ?></a>
				<?php endforeach; ?>
			</div>
		</div>
		<div class="footer-bot">
			<div class="footer-bot-copy">© <?php echo esc_html( ca_year() ); ?> Cool Air USA. All rights reserved. | CAC1816920</div>
			<div class="footer-legal-links">
				<a href="<?php echo esc_url( $base ); ?>privacy-policy/">Privacy Policy</a>
				<span class="footer-legal-sep">·</span>
				<a href="<?php echo esc_url( $base ); ?>terms-of-service/">Terms of Service</a>
				<span class="footer-legal-sep">·</span>
				<a href="<?php echo esc_url( $base ); ?>contact/">Contact</a>
			</div>
			<div class="fbadges">
				<span class="fbadge">⭐ 4.9 Google</span>
				<span class="fbadge">A+ BBB</span>
				<span class="fbadge">Licensed &amp; Insured</span>
				<span class="fbadge">Family Owned &amp; Operated</span>
			</div>
		</div>
	</footer>
	<?php
	return ob_get_clean();
}
