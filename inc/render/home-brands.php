<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function ca_section_brands() {
	$brands  = ca_brands();
	$doubled = array_merge( $brands, $brands );
	ob_start(); ?>
	<div class="brands-section">
		<div class="brands-hdr">Factory Certified On All Major HVAC &amp; Plumbing Brands</div>
		<div class="brands-track">
			<?php foreach ( $doubled as $b ) : ?>
				<div class="brand-chip"><span><?php echo esc_html( $b ); ?></span></div>
			<?php endforeach; ?>
		</div>
	</div>
	<?php
	return ob_get_clean();
}
