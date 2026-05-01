<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function ca_section_stats_bar() {
	$sets = [
		[
			['250,000+','Lifetime Customers'],
			['4,600+','5-Star Google Reviews'],
			['17+','Years Family Owned & Operated'],
			['100+','Cities Served'],
		],
		[
			['38,000+','Service Calls / Year'],
			['23,000+','Installs Completed'],
			['24/7','Real People Answering'],
			['365','Days Open Each Year'],
		],
		[
			['99%','Same-Day Service Rate'],
			['1-Yr','Warranty on All Work'],
			['0','Hidden Fees · Ever'],
			['100%','Licensed & Insured'],
		],
	];
	ob_start(); ?>
	<div class="stats-bar" data-stats-rotator>
		<div class="stats-slider-wrap">
			<div class="stats-slider-track">
				<?php foreach ( $sets as $i => $set ) : ?>
					<div class="stats-slide">
						<?php foreach ( $set as $st ) : ?>
							<div class="stat">
								<div class="stat-val"><?php echo esc_html( $st[0] ); ?></div>
								<div class="stat-lbl"><?php echo esc_html( $st[1] ); ?></div>
							</div>
						<?php endforeach; ?>
					</div>
				<?php endforeach; ?>
			</div>
			<button class="stats-arrow stats-arrow-l" aria-label="Previous">‹</button>
			<button class="stats-arrow stats-arrow-r" aria-label="Next">›</button>
			<div class="stats-dots">
				<?php for ( $i = 0; $i < count( $sets ); $i++ ) : ?>
					<button class="stats-dot<?php echo $i === 0 ? ' active' : ''; ?>" aria-label="Stats <?php echo $i + 1; ?>"></button>
				<?php endfor; ?>
			</div>
		</div>
	</div>
	<?php
	return ob_get_clean();
}

function ca_section_family_band() {
	$pills = [ 'Local Team', 'South Florida Born & Raised', 'Community First' ];
	$stats = [
		[ '2009',   'Founded in Fort Lauderdale, FL' ],
		[ 'Local',  'In-House Team, Not Outsourced' ],
		[ 'Family', 'Values Behind Every Service Call' ],
	];
	ob_start(); ?>
	<div class="family-band">
		<div class="family-band-inner">
			<div>
				<div class="family-eyebrow">Family Owned &amp; Operated</div>
				<h3 class="family-title">Your Neighbors.<br>Not a Franchise.</h3>
				<p class="family-quote">"From our Fort Lauderdale home, we've built this company on honesty and family values — treating every customer the way we'd want our own family treated."</p>
				<div class="family-pills">
					<?php foreach ( $pills as $p ) : ?>
						<div class="family-pill"><span class="family-pill-chk">✓</span><?php echo esc_html( $p ); ?></div>
					<?php endforeach; ?>
				</div>
			</div>
			<?php foreach ( $stats as $s ) : ?>
				<div class="family-stat-box reveal">
					<div class="family-stat-val"><?php echo esc_html( $s[0] ); ?></div>
					<div class="family-stat-lbl"><?php echo esc_html( $s[1] ); ?></div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
	<?php
	return ob_get_clean();
}
