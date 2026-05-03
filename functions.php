<?php
/**
 * Cool Air USA theme bootstrap.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'CA_THEME_VERSION', '1.0.12' );
define( 'CA_THEME_DIR', get_template_directory() );
define( 'CA_THEME_URI', get_template_directory_uri() );
define( 'CA_PHONE', '(954) 915-1155' );
define( 'CA_PHONE_RAW', '9549151155' );
define( 'CA_EMAIL', 'support@coolairusa.com' );
define( 'CA_ADDRESS', '3901 NW 16th St, Fort Lauderdale, FL 33311' );
define( 'CA_PORTAL', 'http://coolairusa.myservicetitan.com' );

require_once CA_THEME_DIR . '/inc/bootstrap.php';
