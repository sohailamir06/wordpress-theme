<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function ca_render_brands_page() {
	$brands = ca_brands();
	ob_start(); ?>
	<div class="ca-brands">
		<?php echo ca_page_hero( 'Brands', 'Brands We Service', 'Cool Air USA is factory certified on every major HVAC and plumbing brand in South Florida. We service equipment from 24+ manufacturers — both legacy and the latest variable-speed systems.', [ 'Factory Certified', 'OEM Parts', 'All Major Brands', '24+ Manufacturers' ] ); ?>

		<section class="content-section">
			<div class="content-in">
				<div class="reveal center">
					<div class="sec-label center">All Brands</div>
					<h2 class="sec-title center">Every Brand In One Trusted Team</h2>
				</div>
				<div class="brands-page-grid">
					<?php foreach ( $brands as $b ) : ?>
						<div class="brand-card"><?php echo esc_html( $b ); ?></div>
					<?php endforeach; ?>
				</div>
				<div class="cta-acts mt-32">
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
