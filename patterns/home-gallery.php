<?php
/**
 * Title: Cool Air - Work Gallery
 * Slug: cool-air-usa/home-gallery
 * Categories: cool-air-usa
 * Inserter: true
 */

$cool_air_gallery_projects = [
	[ 'label' => 'AC Install', 'title' => '5-Ton Carrier Swap', 'location' => 'Coral Gables - Miami-Dade', 'color' => '#2563eb', 'color_2' => '#0f2f68' ],
	[ 'label' => 'Ductwork', 'title' => 'Full Duct Replacement', 'location' => 'Boca Square - Palm Beach', 'color' => '#92400e', 'color_2' => '#171923' ],
	[ 'label' => 'Drain Service', 'title' => 'Main Line Hydro-Jet', 'location' => 'Davie - Broward', 'color' => '#4d7c0f', 'color_2' => '#101827' ],
	[ 'label' => 'Emergency Repair', 'title' => '11PM Burst Pipe Rescue', 'location' => 'Coral Springs - Broward', 'color' => '#dc2626', 'color_2' => '#171923' ],
	[ 'label' => 'AC Repair', 'title' => 'Same-Day Compressor Fix', 'location' => 'Fort Lauderdale - Broward', 'color' => '#0284c7', 'color_2' => '#0f243d' ],
	[ 'label' => 'Plumbing', 'title' => 'Tankless Heater Install', 'location' => 'Pembroke Pines - Broward', 'color' => '#0891b2', 'color_2' => '#102a43' ],
	[ 'label' => 'Commercial', 'title' => 'Rooftop Unit Crane Set', 'location' => 'Miami - Miami-Dade', 'color' => '#7c3aed', 'color_2' => '#111827' ],
	[ 'label' => 'Maintenance', 'title' => 'Annual Tune-Up Visit', 'location' => 'Wellington - Palm Beach', 'color' => '#1d4ed8', 'color_2' => '#0f172a' ],
	[ 'label' => 'UV Lights', 'title' => 'UV-C Coil Protection', 'location' => 'Aventura - Miami-Dade', 'color' => '#0d9488', 'color_2' => '#10212b' ],
	[ 'label' => 'Air Quality', 'title' => 'Whole-Home HEPA Upgrade', 'location' => 'Hollywood - Broward', 'color' => '#0ea5e9', 'color_2' => '#152033' ],
	[ 'label' => 'Thermostat', 'title' => 'Smart Multi-Zone Setup', 'location' => 'Doral - Miami-Dade', 'color' => '#3b82f6', 'color_2' => '#111827' ],
	[ 'label' => 'Pipe Repair', 'title' => 'Kitchen Repipe Finish', 'location' => 'Delray Beach - Palm Beach', 'color' => '#16a34a', 'color_2' => '#102018' ],
];
$cool_air_gallery_total = count( $cool_air_gallery_projects );
?>
<!-- wp:group {"tagName":"section","className":"section gallery-section","layout":{"type":"constrained"}} -->
<section class="wp-block-group section gallery-section" data-gallery data-gallery-autoplay="true">
	<!-- wp:group {"className":"sec-in","layout":{"type":"constrained"}} -->
	<div class="wp-block-group sec-in">
		<!-- wp:group {"className":"reveal gallery-head","layout":{"type":"constrained"}} -->
		<div class="wp-block-group reveal gallery-head">
			<!-- wp:paragraph {"align":"center","className":"sec-label"} -->
			<p class="has-text-align-center sec-label">Real South Florida Jobs</p>
			<!-- /wp:paragraph -->
			<!-- wp:heading {"textAlign":"center","className":"sec-title"} -->
			<h2 class="wp-block-heading has-text-align-center sec-title">OUR WORK, <span style="color: var(--accent)">PHOTOGRAPHED.</span></h2>
			<!-- /wp:heading -->
			<!-- wp:paragraph {"align":"center","className":"sec-sub"} -->
			<p class="has-text-align-center sec-sub">Every Cool Air USA installation includes before-and-after documentation. Spin through recent jobs across Miami-Dade, Broward, and Palm Beach.</p>
			<!-- /wp:paragraph -->
			<!-- wp:paragraph {"align":"center","className":"gallery-count"} -->
			<p class="has-text-align-center gallery-count"><span data-gallery-current>01</span> / <?php echo esc_html( str_pad( (string) $cool_air_gallery_total, 2, '0', STR_PAD_LEFT ) ); ?></p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:group -->

		<!-- wp:group {"className":"gallery-stage","layout":{"type":"constrained"}} -->
		<div class="wp-block-group gallery-stage">
			<!-- wp:group {"className":"gallery-track","layout":{"type":"constrained"}} -->
			<div class="wp-block-group gallery-track" data-gallery-track>
				<?php foreach ( $cool_air_gallery_projects as $cool_air_gallery_index => $cool_air_gallery_project ) : ?>
					<!-- wp:group {"className":"gallery-card","layout":{"type":"constrained"}} -->
					<div class="wp-block-group gallery-card" data-gallery-card="<?php echo esc_attr( (string) $cool_air_gallery_index ); ?>" style="--g-color:<?php echo esc_attr( $cool_air_gallery_project['color'] ); ?>; --g-color-2:<?php echo esc_attr( $cool_air_gallery_project['color_2'] ); ?>;">
						<!-- wp:paragraph {"className":"gallery-card-index"} -->
						<p class="gallery-card-index"><?php echo esc_html( str_pad( (string) ( $cool_air_gallery_index + 1 ), 2, '0', STR_PAD_LEFT ) ); ?></p>
						<!-- /wp:paragraph -->
						<!-- wp:paragraph {"className":"gallery-card-cat"} -->
						<p class="gallery-card-cat"><?php echo esc_html( $cool_air_gallery_project['label'] ); ?></p>
						<!-- /wp:paragraph -->
						<!-- wp:heading {"level":4,"className":"gallery-card-title"} -->
						<h4 class="wp-block-heading gallery-card-title"><?php echo esc_html( $cool_air_gallery_project['title'] ); ?></h4>
						<!-- /wp:heading -->
						<!-- wp:paragraph {"className":"gallery-card-loc"} -->
						<p class="gallery-card-loc"><?php echo esc_html( $cool_air_gallery_project['location'] ); ?></p>
						<!-- /wp:paragraph -->
					</div>
					<!-- /wp:group -->
				<?php endforeach; ?>
			</div>
			<!-- /wp:group -->

			<!-- wp:html -->
			<div class="gallery-controls" aria-label="Gallery controls">
				<button class="gallery-arrow gallery-arrow-l" type="button" aria-label="Previous project">&lsaquo;</button>
				<button class="gallery-toggle" type="button" aria-pressed="true">Auto-Spin</button>
				<button class="gallery-arrow gallery-arrow-r" type="button" aria-label="Next project">&rsaquo;</button>
			</div>
			<!-- /wp:html -->

			<!-- wp:group {"className":"gallery-dots","layout":{"type":"constrained"}} -->
			<div class="wp-block-group gallery-dots" data-gallery-dots>
				<?php for ( $cool_air_gallery_index = 0; $cool_air_gallery_index < $cool_air_gallery_total; $cool_air_gallery_index++ ) : ?>
					<!-- wp:html -->
					<button class="gallery-dot<?php echo 0 === $cool_air_gallery_index ? ' active' : ''; ?>" type="button" aria-label="Show project <?php echo esc_attr( (string) ( $cool_air_gallery_index + 1 ) ); ?>"></button>
					<!-- /wp:html -->
				<?php endfor; ?>
			</div>
			<!-- /wp:group -->

			<!-- wp:paragraph {"align":"center","className":"gallery-hint"} -->
			<p class="has-text-align-center gallery-hint">Hover or tap any card to pause - click side cards to bring them forward - arrow keys to navigate</p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:group -->
	</div>
	<!-- /wp:group -->
</section>
<!-- /wp:group -->
