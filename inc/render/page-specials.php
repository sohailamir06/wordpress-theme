<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function ca_render_specials_page() {
	$specials = [
		[ 'TUNE-UP',     '$89 Spring/Fall A/C Tune-Up',     'Comprehensive 21-point tune-up — coil clean, refrigerant check, full diagnostic. Reg. $129.' ],
		[ 'INSTALL',     '$500 Off Complete System',        'Save $500 on a full A/C replacement install with this current promotion. Includes city permit.' ],
		[ 'SERVICE',     '$50 Off Any Repair',              'New customers save $50 on the first repair we complete in your home. Cannot combine with other offers.' ],
		[ 'MEMBERSHIP', 'Free First Tune-Up',               'Sign up for any membership plan and your first tune-up is on us — a $89 value.' ],
		[ 'PLUMBING',   '$75 Off Water Heater Service',     'Water heater repair or replacement — save $75 with this current promotion.' ],
		[ 'AIR QUALITY','Free UV Light w/ Duct Cleaning',   'Get a UV-C purifier installed free when you book a full-home duct cleaning.' ],
	];
	ob_start(); ?>
	<div class="ca-specials">
		<?php echo ca_page_hero( 'Specials', 'Current Specials &amp; Deals', 'Real savings, no fine print. These promotions are available right now to South Florida homeowners — call us to confirm and lock in your discount.', [ 'Limited Time', 'New Customers', 'No Hidden Fees', 'Stack with Membership' ] ); ?>

		<section class="content-section">
			<div class="content-in">
				<div class="specials-grid">
					<?php foreach ( $specials as $i => $s ) : ?>
						<div class="special-card reveal d<?php echo ( $i % 3 ) + 1; ?>">
							<div class="special-tag"><?php echo esc_html( $s[0] ); ?></div>
							<div class="special-name"><?php echo esc_html( $s[1] ); ?></div>
							<p class="special-desc"><?php echo esc_html( $s[2] ); ?></p>
							<a class="btn-green special-cta" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">Claim This Offer →</a>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</section>

		<?php echo ca_section_emergency(); ?>
	</div>
	<?php
	return ob_get_clean();
}
