<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function ca_section_membership_cta() {
	$perks = [
		'Priority Emergency Scheduling',
		'10% Off All Repairs & Services',
		'Scheduled Maintenance Reminders',
		'Open 24/7 — Always Here',
		'30-Day Service Warranty',
	];
	ob_start(); ?>
	<div class="memb-band">
		<div class="sec-in">
			<div class="reveal">
				<div class="sec-label memb-label">Membership Plans</div>
				<h2 class="sec-title light center">Protect Your A/C Year-Round</h2>
				<p class="sec-sub light center">Scheduled tune-ups, priority scheduling, and 10% off all repairs — because prevention is always cheaper than emergency repairs.</p>
			</div>
			<div class="memb-perks reveal">
				<?php foreach ( $perks as $p ) : ?>
					<div class="memb-perk"><span class="memb-perk-chk">✓</span><?php echo esc_html( $p ); ?></div>
				<?php endforeach; ?>
			</div>
			<div class="memb-cta">
				<a class="btn-white" href="<?php echo esc_url( home_url( '/membership/' ) ); ?>">View Membership Plans →</a>
			</div>
		</div>
	</div>
	<?php
	return ob_get_clean();
}
