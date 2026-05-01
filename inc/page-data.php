<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function ca_service_data() {
	static $data = null;
	if ( $data !== null ) return $data;
	$data = require CA_THEME_DIR . '/inc/data/services.php';
	return $data;
}

function ca_brands() {
	return [
		'Carrier','Rheem','Trane','Daikin','American Standard','Lennox',
		'Goodman','York','Bryant','Ruud','Mitsubishi','Bosch','ClimateMaster',
		'Armstrong','Tempstar','Ameristar','ICP','Bard','Allied','First Co',
	];
}

function ca_reviews() {
	return [
		[ 'text'=>"Fast, professional, and honest. Cool Air USA is the only A/C company I'll ever call. Showed up same day and had us cooling in under an hour.", 'name'=>'Maria G.',  'city'=>'Fort Lauderdale', 'date'=>'2 weeks ago',  'initials'=>'MG' ],
		[ 'text'=>"Called at 10pm for a complete A/C failure. They arrived within the hour and had us cooling before midnight. Absolutely incredible service.",     'name'=>'James R.',  'city'=>'Miami',           'date'=>'1 month ago',  'initials'=>'JR' ],
		[ 'text'=>"Family-owned and it shows. They treat you like a neighbor, not a number. Third time using them and the quality just keeps getting better.",   'name'=>'Sandra L.', 'city'=>'Coral Springs',   'date'=>'3 weeks ago',  'initials'=>'SL' ],
		[ 'text'=>"Brand new A/C installed same week with city permit and everything. Crew was spotless, professional, and explained every step of the process.",'name'=>'Carlos M.', 'city'=>'West Palm Beach', 'date'=>'2 months ago', 'initials'=>'CM' ],
	];
}

function ca_counties() {
	return [
		'palm-beach' => [ 'name'=>'Palm Beach', 'cities'=>[ 'West Palm Beach','Boca Raton','Boynton Beach','Delray Beach','Wellington','Jupiter','Lake Worth','Royal Palm Beach' ] ],
		'broward'    => [ 'name'=>'Broward',    'cities'=>[ 'Fort Lauderdale','Hollywood','Pembroke Pines','Coral Springs','Pompano Beach','Plantation','Sunrise','Davie','Weston','Tamarac' ] ],
		'miami-dade' => [ 'name'=>'Miami-Dade', 'cities'=>[ 'Miami','Miami Beach','Hialeah','Coral Gables','Aventura','Doral','Homestead','Kendall','North Miami','Cutler Bay' ] ],
	];
}
