<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function ca_section_work_gallery() {
	$projects = [
		[ 'AC Install',     'Trane 4-Ton High-Efficiency System',   'Boca Raton',       'Palm Beach',  '#22c55e' ],
		[ 'Duct Cleaning',  'Whole-Home NADCA Cleaning',            'Coral Gables',     'Miami-Dade',  '#f59e0b' ],
		[ 'AC Repair',      'Compressor Replacement Same Day',      'Fort Lauderdale',  'Broward',     '#0ea5e9' ],
		[ 'Plumbing',       'Tankless Water Heater Install',        'Pembroke Pines',   'Broward',     '#06b6d4' ],
		[ 'Commercial',     'Rooftop Unit Crane Service',           'Miami',            'Miami-Dade',  '#8b5cf6' ],
		[ 'AC Maintenance', 'Annual Tune-Up Membership',            'Wellington',       'Palm Beach',  '#3b82f6' ],
		[ 'UV Lights',      'Hospital-Grade UV-C Installation',     'Aventura',         'Miami-Dade',  '#06b6d4' ],
		[ 'Duct Repair',    'Mastic Sealing & Section Replacement', 'Davie',            'Broward',     '#f59e0b' ],
		[ 'AC Install',     'Daikin Variable-Speed System',         'Delray Beach',     'Palm Beach',  '#22c55e' ],
		[ 'Air Purifier',   'Whole-Home HEPA Filtration',           'Hollywood',        'Broward',     '#06b6d4' ],
		[ 'Thermostat',     'Smart Multi-Zone Setup',               'Doral',            'Miami-Dade',  '#3b82f6' ],
		[ 'Emergency',      '11pm Burst Pipe Repair',               'Coral Springs',    'Broward',     '#ef4444' ],
	];
	ob_start(); ?>
	<section class="section gallery-section">
		<div class="sec-in">
			<div class="reveal gallery-head">
				<div class="sec-label">Recent Work</div>
				<h2 class="sec-title">Projects Across South Florida</h2>
				<p class="sec-sub">A look at what we've recently completed for your neighbors. From quick repairs to full installations, every job gets the same care.</p>
			</div>
			<div class="gallery-stage" data-gallery>
				<button class="gallery-arrow gallery-arrow-l" aria-label="Previous">‹</button>
				<div class="gallery-track" data-gallery-track>
					<?php foreach ( $projects as $i => $p ) : ?>
						<div class="gallery-card" data-gallery-card="<?php echo $i; ?>" style="--g-color: <?php echo esc_attr( $p[4] ); ?>;">
							<div class="gallery-card-cat"><?php echo esc_html( $p[0] ); ?></div>
							<h4 class="gallery-card-title"><?php echo esc_html( $p[1] ); ?></h4>
							<div class="gallery-card-loc"><?php echo esc_html( $p[2] ); ?> · <?php echo esc_html( $p[3] ); ?> County</div>
							<div class="gallery-card-foot">Project <?php echo str_pad( $i + 1, 2, '0', STR_PAD_LEFT ); ?> / <?php echo count( $projects ); ?></div>
						</div>
					<?php endforeach; ?>
				</div>
				<button class="gallery-arrow gallery-arrow-r" aria-label="Next">›</button>
				<div class="gallery-dots" data-gallery-dots>
					<?php for ( $i = 0; $i < count( $projects ); $i++ ) : ?>
						<button class="gallery-dot<?php echo $i === 0 ? ' active' : ''; ?>" aria-label="Project <?php echo $i + 1; ?>"></button>
					<?php endfor; ?>
				</div>
			</div>
		</div>
	</section>
	<?php
	return ob_get_clean();
}
