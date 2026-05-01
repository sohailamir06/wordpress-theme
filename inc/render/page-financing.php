<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function ca_render_financing_page() {
	$options = [
		[ '0% APR for 12 Months',     'Zero interest if paid in full within 12 months on qualifying installs.' ],
		[ '0% APR for 18 Months',     'Zero interest if paid in full within 18 months on premium systems.' ],
		[ 'Low Monthly Payments',     'Spread the cost over 60–120 months with predictable monthly payments.' ],
		[ 'No Down Payment',          'Approved customers can install today with $0 down — financing handles the rest.' ],
		[ 'Quick Online Approval',    'Apply in minutes with no impact to your credit. Decisions in seconds.' ],
		[ 'All Credit Levels',        'Multiple lender partners means we can find an option that fits.' ],
	];
	ob_start(); ?>
	<div class="ca-financing">
		<?php echo ca_page_hero( 'Financing', 'Financing Options', 'Cool comfort shouldn\'t wait. Our financing partners offer 0% APR promotions, low monthly payments, and instant online approval — so you can install today.', [ '0% APR Available', 'No Down Payment', 'Quick Approval', 'All Credit Levels' ] ); ?>

		<section class="content-section">
			<div class="content-in">
				<div class="reveal center">
					<div class="sec-label center">Financing</div>
					<h2 class="sec-title center">Multiple Ways to Pay</h2>
					<p class="sec-sub center mx-auto">We work with multiple lending partners to find the right plan for your budget. Most installations qualify for 0% APR promotional financing.</p>
				</div>
				<div class="benefit-cards reveal">
					<?php foreach ( $options as $i => $o ) : ?>
						<div class="benefit-card d<?php echo ( $i % 3 ) + 1; ?>">
							<div class="benefit-title"><?php echo esc_html( $o[0] ); ?></div>
							<p class="benefit-desc"><?php echo esc_html( $o[1] ); ?></p>
						</div>
					<?php endforeach; ?>
				</div>
				<div class="cta-acts reveal mt-32">
					<a class="btn-green" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">Get Pre-Approved →</a>
					<a class="btn-green-call" href="tel:<?php echo CA_PHONE_RAW; ?>">📞 Call <?php echo CA_PHONE; ?></a>
				</div>
			</div>
		</section>

		<?php echo ca_section_emergency(); ?>
	</div>
	<?php
	return ob_get_clean();
}
