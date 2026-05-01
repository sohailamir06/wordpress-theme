<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function ca_render_service_page_block() {
	$slug = ca_current_service_slug();
	return ca_render_service_page( $slug );
}

function ca_render_service_page( $slug ) {
	$data = ca_service_data();
	if ( ! isset( $data[ $slug ] ) ) $slug = 'ac-repair';
	$d = $data[ $slug ];

	ob_start(); ?>
	<div class="ca-service">
		<?php echo ca_service_hero( $d, $slug ); ?>
		<?php echo ca_service_overview( $d ); ?>
		<?php echo ca_service_benefits( $d ); ?>
		<?php echo ca_service_process( $d ); ?>
		<?php echo ca_service_cta(); ?>
	</div>
	<?php
	return ob_get_clean();
}

function ca_service_hero( $d, $slug ) {
	ob_start(); ?>
	<section class="page-hero">
		<div class="page-hero-in">
			<div class="page-hero-split">
				<div class="page-hero-left">
					<div class="page-crumb">Home <span>›</span> Services <span>›</span> <?php echo esc_html( $d['title'] ); ?></div>
					<h1 class="page-title"><?php echo esc_html( $d['title'] ); ?></h1>
					<p class="page-sub"><?php echo esc_html( $d['subtitle'] ); ?></p>
					<div class="page-badges">
						<?php foreach ( $d['badges'] as $b ) : ?>
							<span class="page-badge"><?php echo esc_html( $b ); ?></span>
						<?php endforeach; ?>
					</div>
				</div>
				<div class="page-hero-right">
					<div class="page-hero-card-label">What We Handle</div>
					<div class="issue-grid">
						<?php foreach ( array_slice( $d['issues'], 0, 4 ) as $i ) : ?>
							<div class="issue-card" data-tilt-soft>
								<div class="issue-title"><?php echo esc_html( $i[0] ); ?></div>
								<div class="issue-desc"><?php echo esc_html( $i[1] ); ?></div>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		</div>
	</section>
	<?php
	return ob_get_clean();
}

function ca_service_overview( $d ) {
	ob_start(); ?>
	<section class="content-section dark">
		<div class="content-in center">
			<div class="reveal">
				<div class="sec-label center">Overview</div>
				<h2 class="sec-title light center"><?php echo esc_html( $d['subtitle'] ); ?></h2>
				<p class="sec-sub light center mx-auto"><?php echo esc_html( $d['intro'] ); ?></p>
			</div>
			<div class="cta-acts reveal">
				<a class="btn-green" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">Schedule Service →</a>
				<a class="btn-green-call" href="tel:<?php echo CA_PHONE_RAW; ?>">📞 Call or Text <?php echo CA_PHONE; ?></a>
			</div>
		</div>
	</section>
	<?php
	return ob_get_clean();
}

function ca_service_benefits( $d ) {
	ob_start(); ?>
	<section class="content-section off">
		<div class="content-in">
			<div class="reveal center">
				<div class="sec-label center">The Cool Air Advantage</div>
				<h2 class="sec-title center">Why Customers Choose Us</h2>
			</div>
			<div class="benefit-cards">
				<?php foreach ( $d['benefits'] as $i => $b ) : ?>
					<div class="benefit-card reveal d<?php echo $i + 1; ?>">
						<div class="benefit-icon"><?php echo $b[0]; ?></div>
						<div class="benefit-title"><?php echo esc_html( $b[1] ); ?></div>
						<p class="benefit-desc"><?php echo esc_html( $b[2] ); ?></p>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
	<?php
	return ob_get_clean();
}

function ca_service_process( $d ) {
	ob_start(); ?>
	<section class="content-section">
		<div class="content-in two-col">
			<div class="reveal">
				<div class="sec-label">Our Process</div>
				<h2 class="sec-title">What to Expect</h2>
				<div class="num-steps">
					<?php foreach ( $d['process'] as $i => $p ) : ?>
						<div class="num-step">
							<div class="num-n"><?php echo $i + 1; ?></div>
							<div class="num-step-body">
								<h4><?php echo esc_html( $p[0] ); ?></h4>
								<p><?php echo esc_html( $p[1] ); ?></p>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
			<div class="reveal warranty-card">
				<div class="sec-label warranty-label">The Cool Air Warranty</div>
				<h3 class="warranty-title">Your Service Is Fully Protected</h3>
				<ul class="bullets-list light">
					<li>1-year full parts &amp; labor warranty</li>
					<li>30-day maintenance warranty</li>
					<li>Same issue recurs = free fix</li>
					<li>All parts new &amp; unboxed onsite</li>
				</ul>
				<div class="warranty-acts">
					<a class="btn-green" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">Schedule Now →</a>
					<a class="btn-green-call" href="tel:<?php echo CA_PHONE_RAW; ?>">📞 Call or Text</a>
				</div>
			</div>
		</div>
	</section>
	<?php
	return ob_get_clean();
}

function ca_service_cta() {
	ob_start(); ?>
	<section class="cta-section">
		<div class="content-in">
			<h2 class="sec-title light center">Schedule Your Service Today</h2>
			<p class="sec-sub light center mx-auto">Available 24/7, 365 days a year. You'll always speak to a live agent — never an answering machine.</p>
			<div class="cta-acts">
				<a class="btn-green" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">Book Online →</a>
				<a class="btn-green-call" href="tel:<?php echo CA_PHONE_RAW; ?>">📞 Call or Text <?php echo CA_PHONE; ?></a>
			</div>
		</div>
	</section>
	<?php
	return ob_get_clean();
}
