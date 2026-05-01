<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function ca_render_about_page() {
	$brands = ca_brands();
	$values = [
		[ '🏠', 'Family-Owned',  'Founded in 2009 by a Fort Lauderdale family. Still owned and operated by the same family today.' ],
		[ '🤝', 'Community First','South Florida born and raised. We sponsor local schools, sports, and food drives every year.' ],
		[ '⚖️', 'Honest Pricing', 'Flat-rate pricing means every customer pays the same fair price — no markups, no surprises.' ],
		[ '🛡️', 'Backed Work',   '1-year parts & labor warranty on every repair, every install, every service we provide.' ],
	];
	$milestones = [
		[ '2009', 'Cool Air USA founded in Fort Lauderdale by the founders\' family.' ],
		[ '2014', 'Crossed 50,000 lifetime customers served across South Florida.' ],
		[ '2018', 'NADCA-certified duct cleaning division launched.' ],
		[ '2021', 'Licensed plumbing division added to expand home-services offering.' ],
		[ '2024', 'Crossed 250,000 lifetime customers and 4,600+ five-star Google reviews.' ],
	];
	ob_start(); ?>
	<div class="ca-about">
		<?php echo ca_page_hero( 'About', 'About Cool Air USA', "We're a family business that built South Florida's highest-rated HVAC and plumbing company on one promise: treat every customer the way we'd want our own family treated.", [ 'Family Owned · 2009', 'Licensed CAC1816920', 'A+ BBB Accredited', '4.9★ on 4,600+ Reviews' ] ); ?>

		<section class="content-section">
			<div class="content-in two-col">
				<div class="reveal">
					<div class="sec-label">Our Story</div>
					<h2 class="sec-title">Built On Family Values</h2>
					<p class="sec-sub">Cool Air USA started with a single van and a simple promise — to be the company our neighbors could actually trust. Seventeen years and a quarter-million customers later, we're still that same family business. The phones are still answered by real people in our Fort Lauderdale office. Every install still gets a city permit. Every repair still comes with a 1-year warranty. And every customer still gets the kind of service we'd give our own family.</p>
				</div>
				<div class="reveal benefit-cards">
					<?php foreach ( $values as $i => $v ) : ?>
						<div class="benefit-card d<?php echo $i + 1; ?>">
							<div class="benefit-icon"><?php echo $v[0]; ?></div>
							<div class="benefit-title"><?php echo esc_html( $v[1] ); ?></div>
							<p class="benefit-desc"><?php echo esc_html( $v[2] ); ?></p>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</section>

		<section class="content-section off">
			<div class="content-in">
				<div class="reveal center">
					<div class="sec-label center">Our Journey</div>
					<h2 class="sec-title center">17+ Years &amp; Counting</h2>
				</div>
				<div class="milestones">
					<?php foreach ( $milestones as $i => $m ) : ?>
						<div class="milestone reveal d<?php echo ( $i % 4 ) + 1; ?>">
							<div class="milestone-year"><?php echo esc_html( $m[0] ); ?></div>
							<div class="milestone-text"><?php echo esc_html( $m[1] ); ?></div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</section>

		<section class="content-section">
			<div class="content-in">
				<div class="reveal center">
					<div class="sec-label center">Brands We Service</div>
					<h2 class="sec-title center">Factory Certified On 24+ Brands</h2>
					<p class="sec-sub center mx-auto">From legacy systems to the latest variable-speed equipment, our team trains continuously on every major HVAC and plumbing brand in the market.</p>
				</div>
				<div class="brands-page-grid">
					<?php foreach ( $brands as $b ) : ?>
						<div class="brand-card"><?php echo esc_html( $b ); ?></div>
					<?php endforeach; ?>
				</div>
			</div>
		</section>

		<?php echo ca_section_emergency(); ?>
	</div>
	<?php
	return ob_get_clean();
}
