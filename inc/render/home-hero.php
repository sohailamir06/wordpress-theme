<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function ca_section_hero() {
	$badges = [
		[ '250K+', 'Customers Served' ],
		[ '4.9★',  'Google Rating' ],
		[ '17+',   'Years Family-Owned & Operated' ],
		[ '24/7',  'Always Open For You' ],
	];
	$checks = [ 'Licensed & Insured', '4.9★ · 4,600+ Reviews', 'Same-Day Service', '1-Year Warranty' ];

	ob_start(); ?>
	<section class="hero" data-parallax>
		<div class="hero-bg"></div>
		<div class="hero-float hero-float-a">❄️</div>
		<div class="hero-float hero-float-b">💧</div>
		<div class="hero-split">
			<div>
				<div class="hero-eyebrow">Your Neighbors. Not a Franchise. Since 2009.</div>
				<h1 class="hero-h1"><em>HVAC &amp;</em><br><em>Plumbing</em><br>Experts<br>You Can<br>Trust</h1>
				<p class="hero-sub">Honest pricing, same-day service, and a team that treats your home like their own. South Florida's most trusted HVAC and plumbing company — Open 24/7, 365 days a year.</p>
				<div class="hero-acts">
					<a class="btn-green" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">Schedule Service →</a>
					<a class="btn-outline-w" href="tel:<?php echo CA_PHONE_RAW; ?>">📞 <?php echo CA_PHONE; ?></a>
				</div>
				<div class="hero-checks">
					<?php foreach ( $checks as $c ) : ?>
						<div class="hero-check"><span class="hero-check-icon">✓</span><?php echo esc_html( $c ); ?></div>
					<?php endforeach; ?>
				</div>
			</div>
			<div class="hero-right">
				<div class="hero-logo-card">
					<img src="<?php echo CA_THEME_URI; ?>/assets/images/logo4t.png" alt="Cool Air USA" height="210">
				</div>
				<div class="hero-badges">
					<?php foreach ( $badges as $b ) : ?>
						<div class="hero-badge">
							<div class="hero-badge-val"><?php echo esc_html( $b[0] ); ?></div>
							<div class="hero-badge-lbl"><?php echo esc_html( $b[1] ); ?></div>
						</div>
					<?php endforeach; ?>
				</div>
				<?php echo ca_google_rating_card(); ?>
			</div>
		</div>
		<div class="scroll-indicator">
			<span class="scroll-label">Scroll</span>
			<div class="scroll-line"></div>
		</div>
	</section>
	<?php
	return ob_get_clean();
}

function ca_google_rating_card() {
	ob_start(); ?>
	<div class="grating-card">
		<div class="grating-g-pill">
			<span class="grating-g">G</span>
		</div>
		<div class="grating-meta">
			<div class="grating-row">
				<span class="grating-num">4.9</span>
				<span class="grating-stars">★★★★★</span>
			</div>
			<div class="grating-sub">Based on 4,600+ Google reviews</div>
		</div>
		<a class="grating-link" href="#reviews">Read All →</a>
	</div>
	<?php
	return ob_get_clean();
}
