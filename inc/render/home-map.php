<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function ca_section_service_areas_map() {
	$counties = ca_counties();
	ob_start(); ?>
	<section class="section map-section">
		<div class="sec-in">
			<div class="reveal map-head">
				<div class="sec-label">Service Coverage</div>
				<h2 class="sec-title light">Serving 80+ Cities Across South Florida</h2>
				<p class="sec-sub light">Hover any city below to see how many of your neighbors trust Cool Air USA for HVAC and plumbing service.</p>
			</div>
			<div class="reveal county-cards">
				<?php foreach ( $counties as $slug => $county ) : ?>
					<div class="county-card" data-county="<?php echo esc_attr( $slug ); ?>">
						<div class="county-card-icon"><?php
							echo $slug === 'palm-beach' ? '🌴' : ( $slug === 'broward' ? '🏖️' : '🌆' );
						?></div>
						<div class="county-card-name"><?php echo esc_html( $county['name'] ); ?> County</div>
						<div class="county-card-cities">
							<?php echo esc_html( implode( ' · ', array_slice( $county['cities'], 0, 4 ) ) ); ?>
							<?php if ( count( $county['cities'] ) > 4 ) : ?>
								<span class="county-card-more">+ <?php echo count( $county['cities'] ) - 4; ?> more</span>
							<?php endif; ?>
						</div>
						<a class="county-card-link" href="<?php echo esc_url( home_url( '/service-areas/' ) ); ?>">View All <?php echo esc_html( $county['name'] ); ?> Cities →</a>
					</div>
				<?php endforeach; ?>
			</div>
			<div class="reveal map-cta-wrap">
				<a class="btn-green" href="<?php echo esc_url( home_url( '/service-areas/' ) ); ?>">View All Service Areas →</a>
			</div>
		</div>
	</section>
	<?php
	return ob_get_clean();
}
