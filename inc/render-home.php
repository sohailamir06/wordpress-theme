<?php
if ( ! defined( 'ABSPATH' ) ) exit;

require_once CA_THEME_DIR . '/inc/render/home-hero.php';
require_once CA_THEME_DIR . '/inc/render/home-stats.php';
require_once CA_THEME_DIR . '/inc/render/home-services.php';
require_once CA_THEME_DIR . '/inc/render/home-why.php';
require_once CA_THEME_DIR . '/inc/render/home-reviews.php';
require_once CA_THEME_DIR . '/inc/render/home-process.php';
require_once CA_THEME_DIR . '/inc/render/home-brands.php';
require_once CA_THEME_DIR . '/inc/render/home-map.php';
require_once CA_THEME_DIR . '/inc/render/home-membership.php';
require_once CA_THEME_DIR . '/inc/render/home-gallery.php';
require_once CA_THEME_DIR . '/inc/render/home-emergency.php';
require_once CA_THEME_DIR . '/inc/render/site-header.php';
require_once CA_THEME_DIR . '/inc/render/site-footer.php';

function ca_render_homepage() {
	ob_start(); ?>
	<div class="ca-home">
		<?php echo ca_section_hero(); ?>
		<?php echo ca_section_stats_bar(); ?>
		<?php echo ca_section_family_band(); ?>
		<?php echo ca_section_services(); ?>
		<?php echo ca_section_why(); ?>
		<?php echo ca_section_reviews(); ?>
		<?php echo ca_section_process(); ?>
		<?php echo ca_section_brands(); ?>
		<?php echo ca_section_service_areas_map(); ?>
		<?php echo ca_section_membership_cta(); ?>
		<?php echo ca_section_work_gallery(); ?>
		<?php echo ca_section_emergency(); ?>
	</div>
	<?php
	return ob_get_clean();
}
