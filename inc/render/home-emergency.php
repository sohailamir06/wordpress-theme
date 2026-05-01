<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function ca_section_emergency() {
	$scenarios = [
		[ '🔥', 'No A/C or Heat' ],
		[ '💧', 'Water Heater Failure' ],
		[ '❄️', 'Frozen Coils / Lines' ],
		[ '🚨', 'Total System Failure' ],
		[ '🚿', 'Drain Backup' ],
		[ '⚡', 'Electrical Failure' ],
	];
	$mini_stats = [
		[ '24/7',        'Always Open' ],
		[ '≤60 min',     'Avg Response' ],
		[ '1 Year',      'Repair Warranty' ],
		[ 'Real People', 'Not Machines' ],
	];
	ob_start(); ?>
	<div class="emg-enhanced">
		<div class="emg-watermark">24/7</div>
		<div class="emg-inner">
			<div class="emg-left">
				<div class="emg-live-badge">
					<span class="emg-live-dot"></span>
					<span class="emg-live-text">Open 24/7/365 — Emergency Dispatch</span>
				</div>
				<h2 class="emg-h2">A/C Down? Water Heater Out?<br><span class="emg-h2-red">We're On The Way.</span></h2>
				<p class="emg-sub">HVAC and plumbing emergencies don't keep business hours. We're open around the clock — real people answer your call and dispatch the nearest certified technician right away.</p>
				<div class="emg-scenarios">
					<?php foreach ( $scenarios as $sc ) : ?>
						<div class="emg-scenario"><span><?php echo $sc[0]; ?></span><?php echo esc_html( $sc[1] ); ?></div>
					<?php endforeach; ?>
				</div>
			</div>
			<div class="emg-right">
				<a class="btn-red emg-call" href="tel:<?php echo CA_PHONE_RAW; ?>">📞 <?php echo CA_PHONE; ?></a>
				<div class="emg-mini-grid">
					<?php foreach ( $mini_stats as $s ) : ?>
						<div class="emg-stat-mini">
							<div class="emg-stat-mini-val"><?php echo esc_html( $s[0] ); ?></div>
							<div class="emg-stat-mini-lbl"><?php echo esc_html( $s[1] ); ?></div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</div>
	<?php
	return ob_get_clean();
}
