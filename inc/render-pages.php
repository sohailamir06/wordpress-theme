<?php
if ( ! defined( 'ABSPATH' ) ) exit;

require_once CA_THEME_DIR . '/inc/render/page-about.php';
require_once CA_THEME_DIR . '/inc/render/page-contact.php';
require_once CA_THEME_DIR . '/inc/render/page-membership.php';
require_once CA_THEME_DIR . '/inc/render/page-financing.php';
require_once CA_THEME_DIR . '/inc/render/page-careers.php';
require_once CA_THEME_DIR . '/inc/render/page-specials.php';
require_once CA_THEME_DIR . '/inc/render/page-brands.php';
require_once CA_THEME_DIR . '/inc/render/page-service-areas.php';
require_once CA_THEME_DIR . '/inc/render/page-legal.php';

function ca_page_hero( $crumb, $title, $subtitle, $badges = [] ) {
	ob_start(); ?>
	<section class="page-hero">
		<div class="page-hero-in">
			<div class="page-crumb">Home <span>›</span> <?php echo esc_html( $crumb ); ?></div>
			<h1 class="page-title"><?php echo esc_html( $title ); ?></h1>
			<p class="page-sub"><?php echo esc_html( $subtitle ); ?></p>
			<?php if ( $badges ) : ?>
				<div class="page-badges">
					<?php foreach ( $badges as $b ) : ?>
						<span class="page-badge"><?php echo esc_html( $b ); ?></span>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>
	</section>
	<?php
	return ob_get_clean();
}
