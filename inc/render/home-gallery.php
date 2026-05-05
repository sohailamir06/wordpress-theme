<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function ca_get_work_gallery_projects() {
	return [
		[ 'label' => 'AC Install', 'title' => '5-Ton Carrier Swap', 'location' => 'Coral Gables - Miami-Dade', 'color' => '#2563eb', 'color_2' => '#0f2f68' ],
		[ 'label' => 'Ductwork', 'title' => 'Full Duct Replacement', 'location' => 'Boca Square - Palm Beach', 'color' => '#92400e', 'color_2' => '#171923' ],
		[ 'label' => 'Thermostat', 'title' => 'Smart Multi-Zone Setup', 'location' => 'Doral - Miami-Dade', 'color' => '#3b82f6', 'color_2' => '#111827' ],
		[ 'label' => 'Emergency Repair', 'title' => '11PM Burst Pipe Rescue', 'location' => 'Coral Springs - Broward', 'color' => '#dc2626', 'color_2' => '#171923' ],
		[ 'label' => 'Indoor Air', 'title' => 'Whole-home UV purifier', 'location' => 'Weston - Broward', 'color' => '#1e4d5c', 'color_2' => '#0d2631' ],
		[ 'label' => 'Coastal AC', 'title' => 'Salt-rated condenser', 'location' => 'Highland Beach - Palm Beach', 'color' => '#6b5c3e', 'color_2' => '#3a3220' ],
		[ 'label' => 'Repipe', 'title' => 'Whole-home copper repipe', 'location' => 'Pembroke Pines - Broward', 'color' => '#4a1e5c', 'color_2' => '#2a0f3c' ],
		[ 'label' => 'AC Repair', 'title' => 'Same-Day Compressor Fix', 'location' => 'Fort Lauderdale - Broward', 'color' => '#0284c7', 'color_2' => '#0f243d' ],
		[ 'label' => 'Plumbing', 'title' => 'Tankless Heater Install', 'location' => 'Pembroke Pines - Broward', 'color' => '#0891b2', 'color_2' => '#102a43' ],
		[ 'label' => 'UV Lights', 'title' => 'UV-C Coil Protection', 'location' => 'Aventura - Miami-Dade', 'color' => '#0d9488', 'color_2' => '#10212b' ],
		[ 'label' => 'Commercial', 'title' => 'Rooftop Unit Installation', 'location' => 'Miami - Miami-Dade', 'color' => '#7c3aed', 'color_2' => '#111827' ],
		[ 'label' => 'Maintenance', 'title' => 'Annual Tune-Up Visit', 'location' => 'Wellington - Palm Beach', 'color' => '#1d4ed8', 'color_2' => '#0f172a' ],
	];
}

function ca_section_work_gallery() {
	$projects = ca_get_work_gallery_projects();
	$total    = count( $projects );

	ob_start(); ?>
	<section class="section gallery-section" data-gallery data-gallery-autoplay="true">
		<div class="sec-in">
			<div class="reveal gallery-head">
				<div class="sec-label">Real South Florida Jobs</div>
			<h2 class="sec-title">OUR WORK, <span style="color: var(--accent)">PHOTOGRAPHED.</span></h2>
				<p class="sec-sub">Every Cool Air USA installation includes before-and-after documentation. Spin through recent jobs across Miami-Dade, Broward, and Palm Beach.</p>
				<p class="gallery-count"><span data-gallery-current>01</span> / <?php echo esc_html( str_pad( (string) $total, 2, '0', STR_PAD_LEFT ) ); ?></p>
			</div>

			<div class="gallery-stage">
				<div class="gallery-track" data-gallery-track>
					<?php foreach ( $projects as $i => $project ) : ?>
						<button class="gallery-card" data-gallery-card="<?php echo esc_attr( (string) $i ); ?>" type="button" style="--g-color:<?php echo esc_attr( $project['color'] ); ?>; --g-color-2:<?php echo esc_attr( $project['color_2'] ); ?>;">
							<span class="gallery-card-index"><?php echo esc_html( str_pad( (string) ( $i + 1 ), 2, '0', STR_PAD_LEFT ) ); ?></span>
							<span class="gallery-card-cat"><?php echo esc_html( $project['label'] ); ?></span>
							<span class="gallery-card-title"><?php echo esc_html( $project['title'] ); ?></span>
							<span class="gallery-card-loc"><?php echo esc_html( $project['location'] ); ?></span>
						</button>
					<?php endforeach; ?>
				</div>

				<div class="gallery-controls" aria-label="Gallery controls">
					<button class="gallery-arrow gallery-arrow-l" type="button" aria-label="Previous project">&lsaquo;</button>
					<button class="gallery-toggle" type="button" aria-pressed="true">Auto-Spin</button>
					<button class="gallery-arrow gallery-arrow-r" type="button" aria-label="Next project">&rsaquo;</button>
				</div>

				<div class="gallery-dots" data-gallery-dots>
					<?php for ( $i = 0; $i < $total; $i++ ) : ?>
						<button class="gallery-dot<?php echo 0 === $i ? ' active' : ''; ?>" type="button" aria-label="Show project <?php echo esc_attr( (string) ( $i + 1 ) ); ?>"></button>
					<?php endfor; ?>
				</div>

				<p class="gallery-hint">Hover or tap any card to pause - click side cards to bring them forward - arrow keys to navigate</p>
			</div>
		</div>
	</section>
	<?php
	return ob_get_clean();
}
