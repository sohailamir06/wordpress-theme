<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function ca_section_services() {
	$services = [
		[ 'HVAC',        'AC Repair',         'Same-day repairs on all A/C systems. Flat-rate pricing, manufacturer parts, 1-year warranty.', 'ac-repair',     '#0ea5e9' ],
		[ 'HVAC',        'AC Installation',   'Free estimates, city permits, all top brands. 1-year labor + up to 10-year parts warranty.',  'ac-install',    '#22c55e' ],
		[ 'HVAC',        'AC Maintenance',    "Spring & fall tune-ups to prevent breakdowns and extend your system's life significantly.",   'ac-maintenance','#3b82f6' ],
		[ 'COMMERCIAL',  'Commercial HVAC',   'Crane-capable commercial service for offices, retail, and restaurants — fast and stocked.',   'commercial',    '#8b5cf6' ],
		[ 'DUCTS',       'Duct Services',     'NADCA-certified cleaning, repair & full replacement. City permitted and guaranteed.',         'duct-cleaning', '#f59e0b' ],
		[ 'AIR QUALITY', 'Air Quality',       'UV lights, air purifiers, HEPA filters, and smart thermostats for healthier home air.',       'uv-lights',     '#06b6d4' ],
		[ 'PLUMBING',    'Plumbing',          'Water heaters, drain cleaning, pipe repair, leak detection & fixture work. Licensed.',         'plumbing',      '#0891b2' ],
		[ 'EMERGENCY',   'Emergency 24/7',    'Open around the clock — real people answer your call. We dispatch immediately.',              'emergency',     '#ef4444' ],
	];
	ob_start(); ?>
	<section class="section svcs-section">
		<div class="sec-in">
			<div class="reveal">
				<div class="sec-label">HVAC &amp; Plumbing Services</div>
				<h2 class="sec-title">Everything Your Home Needs</h2>
				<p class="sec-sub">From emergency A/C repairs to full system installs, duct work, air quality, and licensed plumbing — all under one trusted, family-owned and operated roof.</p>
			</div>
			<div class="svcs-grid">
				<?php foreach ( $services as $i => $s ) : ?>
					<a class="svc-card-mod reveal d<?php echo ( $i % 4 ) + 1; ?>"
					   href="<?php echo esc_url( home_url( '/services/' . $s[3] . '/' ) ); ?>"
					   style="--svc-color: <?php echo esc_attr( $s[4] ); ?>;">
						<div class="svc-cat"><?php echo esc_html( $s[0] ); ?></div>
						<div class="svc-name"><?php echo esc_html( $s[1] ); ?></div>
						<p class="svc-desc"><?php echo esc_html( $s[2] ); ?></p>
						<div class="svc-link">Learn More →</div>
					</a>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
	<?php
	return ob_get_clean();
}
