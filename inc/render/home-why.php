<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function ca_section_why() {
	$features = [
		[ '⚡',  'Same-Day Service', 'Emergency calls dispatched fast. Fully stocked vans mean most problems solved in one visit.', '#0ea5e9' ],
		[ '🏆', 'Factory Certified', 'Trained on every major HVAC brand in South Florida — residential and commercial.',           '#22c55e' ],
		[ '💰', 'Flat-Rate Pricing', 'No hourly billing or hidden charges. Every customer pays the same honest, transparent price.','#f59e0b' ],
		[ '🛡️', '1-Year Warranty',   'Every repair backed by a full 1-year parts & labor warranty. No exceptions, no questions.',   '#8b5cf6' ],
		[ '🏙️', 'City Permitted',    "Every installation comes with a city permit — protecting your home's value and your peace of mind.", '#ef4444' ],
		[ '📞', 'Open 24/7',         'Real people answer your call around the clock. Never a machine. Never a voicemail.',          '#06b6d4' ],
	];
	ob_start(); ?>
	<section class="section why-section">
		<div class="sec-in">
			<div class="reveal why-header">
				<div class="sec-label">Why Your Neighbors Choose Us</div>
				<h2 class="sec-title">South Florida's Trusted Choice Since 2009</h2>
				<p class="sec-sub">We've served over 250,000 South Florida families through honest pricing, expert work, and a team that genuinely cares about your comfort and your home.</p>
			</div>
			<div class="why-grid">
				<?php foreach ( $features as $i => $f ) : ?>
					<div class="why-card reveal d<?php echo ( $i % 3 ) + 1; ?>" data-tilt style="--why-color: <?php echo esc_attr( $f[3] ); ?>;">
						<div class="why-bar"></div>
						<div class="why-icon-wrap"><?php echo $f[0]; ?></div>
						<div class="why-title"><?php echo esc_html( $f[1] ); ?></div>
						<p class="why-desc"><?php echo esc_html( $f[2] ); ?></p>
					</div>
				<?php endforeach; ?>
			</div>
			<div class="why-cta">
				<a class="btn-green" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">Schedule Service Today →</a>
				<a class="btn-green-call" href="tel:<?php echo CA_PHONE_RAW; ?>">📞 Call or Text <?php echo CA_PHONE; ?></a>
			</div>
		</div>
	</section>
	<?php
	return ob_get_clean();
}
