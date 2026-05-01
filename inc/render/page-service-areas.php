<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function ca_render_service_areas_page() {
	$counties = ca_counties();
	ob_start(); ?>
	<div class="ca-service-areas">
		<?php echo ca_page_hero( 'Service Areas', 'Service Areas Across South Florida', 'We serve over 80 cities across Miami-Dade, Broward, and Palm Beach counties. Same-day service throughout our entire coverage area, 24/7 emergency dispatch.', [ '80+ Cities', '3 Counties', 'Same-Day Service', '24/7 Dispatch' ] ); ?>

		<section class="content-section">
			<div class="content-in">
				<div class="counties-grid">
					<?php foreach ( $counties as $slug => $c ) : ?>
						<div class="counties-block reveal">
							<div class="counties-block-name"><?php echo esc_html( $c['name'] ); ?> County</div>
							<div class="counties-block-count"><?php echo count( $c['cities'] ); ?>+ Cities Served</div>
							<div class="counties-cities">
								<?php foreach ( $c['cities'] as $city ) : ?>
									<a class="county-city" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><?php echo esc_html( $city ); ?></a>
								<?php endforeach; ?>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
				<div class="cta-acts mt-32 center">
					<a class="btn-green" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">Schedule Service →</a>
					<a class="btn-green-call" href="tel:<?php echo CA_PHONE_RAW; ?>">📞 Call <?php echo CA_PHONE; ?></a>
				</div>
			</div>
		</section>

		<?php echo ca_section_emergency(); ?>
	</div>
	<?php
	return ob_get_clean();
}
