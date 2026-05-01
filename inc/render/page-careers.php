<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function ca_render_careers_page() {
	$jobs = [
		[ 'HVAC Service Technician',     'Full-time · Fort Lauderdale',  'NATE-certified or equivalent. 3+ years residential service experience.' ],
		[ 'Installation Technician',     'Full-time · Broward County',   'EPA 608 required. New install &amp; replacement experience preferred.' ],
		[ 'Plumber (Journeyman)',        'Full-time · South Florida',    'FL Journeyman license. Residential and light commercial experience.' ],
		[ 'Customer Care Agent',         'Full-time · Fort Lauderdale',  'Real-people answering. Friendly voice, fast typing, problem-solver mindset.' ],
		[ 'Comfort Specialist (Sales)',  'Full-time · Field-based',      'Help homeowners pick the right system. Salary plus performance bonuses.' ],
	];
	$perks = [
		[ '🏥', 'Health Coverage', 'Medical, dental, and vision benefits for full-time employees.' ],
		[ '💰', 'Paid Training',   'Continuous training on every major brand. We invest in our team.' ],
		[ '📈', '401(k) Match',    'Company matches contributions up to 4% of your salary.' ],
		[ '🌴', 'Paid Time Off',   'Vacation, sick days, and major holidays — paid.' ],
		[ '🚐', 'Take-Home Truck', 'Service techs get a fully stocked van — no more starting at the shop.' ],
		[ '👨‍👩‍👧', 'Family Culture',  'We treat our team like family. Real growth, real respect, real opportunity.' ],
	];
	ob_start(); ?>
	<div class="ca-careers">
		<?php echo ca_page_hero( 'Careers', 'Join the Cool Air Family', 'We hire people, not just resumes. If you take pride in your work and treat every customer right, we want you on the team.', [ 'Full Benefits', 'Paid Training', 'Take-Home Truck', 'Family-Owned' ] ); ?>

		<section class="content-section">
			<div class="content-in">
				<div class="reveal center">
					<div class="sec-label center">Open Positions</div>
					<h2 class="sec-title center">We're Hiring</h2>
				</div>
				<div class="jobs-list reveal">
					<?php foreach ( $jobs as $j ) : ?>
						<div class="job-card">
							<div>
								<div class="job-title"><?php echo esc_html( $j[0] ); ?></div>
								<div class="job-meta"><?php echo esc_html( $j[1] ); ?></div>
								<p class="job-desc"><?php echo wp_kses_post( $j[2] ); ?></p>
							</div>
							<a class="btn-green" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">Apply →</a>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</section>

		<section class="content-section off">
			<div class="content-in">
				<div class="reveal center">
					<div class="sec-label center">Why Cool Air</div>
					<h2 class="sec-title center">Benefits &amp; Culture</h2>
				</div>
				<div class="benefit-cards">
					<?php foreach ( $perks as $i => $p ) : ?>
						<div class="benefit-card reveal d<?php echo ( $i % 3 ) + 1; ?>">
							<div class="benefit-icon"><?php echo $p[0]; ?></div>
							<div class="benefit-title"><?php echo esc_html( $p[1] ); ?></div>
							<p class="benefit-desc"><?php echo esc_html( $p[2] ); ?></p>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</section>
	</div>
	<?php
	return ob_get_clean();
}
