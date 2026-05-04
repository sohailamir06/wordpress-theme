<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function ca_section_process() {
	$steps = [
		[ 'Call or Book Online', 'Reach us at ' . CA_PHONE . " or book online. We're open 24/7/365 - a real person in our office answers, never a machine." ],
		[ 'Tech Arrives Fast', 'A certified, factory-trained technician arrives in a fully stocked van - typically within hours, ready to diagnose and fix.' ],
		[ 'Clear Flat-Rate Quote', "We explain what's wrong in plain English and give a flat-rate price before any work begins. No surprises." ],
		[ 'Problem Solved', 'Repair done, system tested, invoice emailed with before & after photos. Comfort restored - guaranteed.' ],
	];

	ob_start(); ?>
	<section id="process" class="section process-section process-v3" data-process data-process-start="1">
		<div class="sec-in">
			<div class="reveal process-head">
				<div class="sec-label">Simple &amp; Transparent</div>
				<h2 class="sec-title">From Call to Cool in 4 Steps</h2>
				<p class="sec-sub">We make it easy. Here's exactly what happens the moment you reach out.</p>
			</div>

			<div class="process-road">
				<div class="process-road-base"></div>
				<div class="process-road-fill" data-process-fill></div>
				<div class="process-road-dashed"></div>
				<div class="process-van-wrap">
					<div class="process-van" data-process-van aria-hidden="true"></div>
				</div>
			</div>

			<div class="process-grid">
				<?php foreach ( $steps as $i => $st ) : ?>
					<div class="proc-step reveal d<?php echo esc_attr( $i + 1 ); ?>" data-step="<?php echo esc_attr( $i ); ?>">
						<div class="proc-num"><?php echo esc_html( $i + 1 ); ?></div>
						<div class="proc-title"><?php echo esc_html( $st[0] ); ?></div>
						<p class="proc-desc"><?php echo esc_html( $st[1] ); ?></p>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
	<?php
	return ob_get_clean();
}
