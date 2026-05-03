<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Build service pages with fully editable core blocks.
 */
function ca_render_service_page_builder_content( $slug ) {
	$data = ca_service_data();
	if ( ! isset( $data[ $slug ] ) ) {
		$slug = 'ac-repair';
	}
	$d = $data[ $slug ];

	ob_start();
	?>
<!-- wp:group {"tagName":"section","className":"page-hero","layout":{"type":"constrained"}} -->
<section class="wp-block-group page-hero">
	<!-- wp:group {"className":"page-hero-in","layout":{"type":"constrained"}} -->
	<div class="wp-block-group page-hero-in">
		<!-- wp:columns {"className":"page-hero-split"} -->
		<div class="wp-block-columns page-hero-split">
			<!-- wp:column {"className":"page-hero-left"} -->
			<div class="wp-block-column page-hero-left">
				<!-- wp:paragraph {"className":"page-crumb"} -->
				<p class="page-crumb">Home <span>&gt;</span> Services <span>&gt;</span> <?php echo esc_html( $d['title'] ); ?></p>
				<!-- /wp:paragraph -->
				<!-- wp:heading {"level":1,"className":"page-title"} -->
				<h1 class="wp-block-heading page-title"><?php echo esc_html( $d['title'] ); ?></h1>
				<!-- /wp:heading -->
				<!-- wp:paragraph {"className":"page-sub"} -->
				<p class="page-sub"><?php echo esc_html( $d['subtitle'] ); ?></p>
				<!-- /wp:paragraph -->
				<!-- wp:group {"className":"page-badges","layout":{"type":"constrained"}} -->
				<div class="wp-block-group page-badges">
					<?php foreach ( $d['badges'] as $badge ) : ?>
					<span class="page-badge"><?php echo esc_html( $badge ); ?></span>
					<?php endforeach; ?>
				</div>
				<!-- /wp:group -->
			</div>
			<!-- /wp:column -->
			<!-- wp:column {"className":"page-hero-right"} -->
			<div class="wp-block-column page-hero-right">
				<!-- wp:paragraph {"className":"page-hero-card-label"} -->
				<p class="page-hero-card-label">What We Handle</p>
				<!-- /wp:paragraph -->
				<!-- wp:group {"className":"issue-grid","layout":{"type":"constrained"}} -->
				<div class="wp-block-group issue-grid">
					<?php foreach ( array_slice( $d['issues'], 0, 4 ) as $issue ) : ?>
					<!-- wp:group {"className":"issue-card","layout":{"type":"constrained"}} -->
					<div class="wp-block-group issue-card">
						<!-- wp:paragraph {"className":"issue-title"} -->
						<p class="issue-title"><?php echo esc_html( $issue[0] ); ?></p>
						<!-- /wp:paragraph -->
						<!-- wp:paragraph {"className":"issue-desc"} -->
						<p class="issue-desc"><?php echo esc_html( $issue[1] ); ?></p>
						<!-- /wp:paragraph -->
					</div>
					<!-- /wp:group -->
					<?php endforeach; ?>
				</div>
				<!-- /wp:group -->
			</div>
			<!-- /wp:column -->
		</div>
		<!-- /wp:columns -->
	</div>
	<!-- /wp:group -->
</section>
<!-- /wp:group -->

<!-- wp:group {"tagName":"section","className":"content-section dark","layout":{"type":"constrained"}} -->
<section class="wp-block-group content-section dark">
	<!-- wp:group {"className":"content-in center","layout":{"type":"constrained"}} -->
	<div class="wp-block-group content-in center">
		<!-- wp:group {"className":"reveal","layout":{"type":"constrained"}} -->
		<div class="wp-block-group reveal">
			<!-- wp:paragraph {"align":"center","className":"sec-label center"} -->
			<p class="has-text-align-center sec-label center">Overview</p>
			<!-- /wp:paragraph -->
			<!-- wp:heading {"textAlign":"center","level":2,"className":"sec-title light center"} -->
			<h2 class="wp-block-heading has-text-align-center sec-title light center"><?php echo esc_html( $d['subtitle'] ); ?></h2>
			<!-- /wp:heading -->
			<!-- wp:paragraph {"align":"center","className":"sec-sub light center mx-auto"} -->
			<p class="has-text-align-center sec-sub light center mx-auto"><?php echo esc_html( $d['intro'] ); ?></p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:group -->
		<!-- wp:buttons {"className":"cta-acts reveal","layout":{"type":"flex","justifyContent":"center"}} -->
		<div class="wp-block-buttons cta-acts reveal">
			<!-- wp:button {"className":"btn-green"} -->
			<div class="wp-block-button btn-green"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">Schedule Service -&gt;</a></div>
			<!-- /wp:button -->
			<!-- wp:button {"className":"btn-green-call"} -->
			<div class="wp-block-button btn-green-call"><a class="wp-block-button__link wp-element-button" href="tel:<?php echo esc_attr( CA_PHONE_RAW ); ?>">Call or Text <?php echo esc_html( CA_PHONE ); ?></a></div>
			<!-- /wp:button -->
		</div>
		<!-- /wp:buttons -->
	</div>
	<!-- /wp:group -->
</section>
<!-- /wp:group -->

<!-- wp:group {"tagName":"section","className":"content-section off","layout":{"type":"constrained"}} -->
<section class="wp-block-group content-section off">
	<!-- wp:group {"className":"content-in","layout":{"type":"constrained"}} -->
	<div class="wp-block-group content-in">
		<!-- wp:group {"className":"reveal center","layout":{"type":"constrained"}} -->
		<div class="wp-block-group reveal center">
			<!-- wp:paragraph {"align":"center","className":"sec-label center"} -->
			<p class="has-text-align-center sec-label center">The Cool Air Advantage</p>
			<!-- /wp:paragraph -->
			<!-- wp:heading {"textAlign":"center","level":2,"className":"sec-title center"} -->
			<h2 class="wp-block-heading has-text-align-center sec-title center">Why Customers Choose Us</h2>
			<!-- /wp:heading -->
		</div>
		<!-- /wp:group -->
		<!-- wp:group {"className":"benefit-cards","layout":{"type":"grid","minimumColumnWidth":"260px"}} -->
		<div class="wp-block-group benefit-cards">
			<?php foreach ( $d['benefits'] as $index => $benefit ) : ?>
			<!-- wp:group {"className":"benefit-card reveal d<?php echo esc_attr( (string) ( $index + 1 ) ); ?>","layout":{"type":"constrained"}} -->
			<div class="wp-block-group benefit-card reveal d<?php echo esc_attr( (string) ( $index + 1 ) ); ?>">
				<!-- wp:paragraph {"className":"benefit-title"} -->
				<p class="benefit-title"><?php echo esc_html( $benefit[1] ); ?></p>
				<!-- /wp:paragraph -->
				<!-- wp:paragraph {"className":"benefit-desc"} -->
				<p class="benefit-desc"><?php echo esc_html( $benefit[2] ); ?></p>
				<!-- /wp:paragraph -->
			</div>
			<!-- /wp:group -->
			<?php endforeach; ?>
		</div>
		<!-- /wp:group -->
	</div>
	<!-- /wp:group -->
</section>
<!-- /wp:group -->

<!-- wp:group {"tagName":"section","className":"content-section","layout":{"type":"constrained"}} -->
<section class="wp-block-group content-section">
	<!-- wp:columns {"className":"content-in two-col"} -->
	<div class="wp-block-columns content-in two-col">
		<!-- wp:column {"className":"reveal"} -->
		<div class="wp-block-column reveal">
			<!-- wp:paragraph {"className":"sec-label"} -->
			<p class="sec-label">Our Process</p>
			<!-- /wp:paragraph -->
			<!-- wp:heading {"level":2,"className":"sec-title"} -->
			<h2 class="wp-block-heading sec-title">What to Expect</h2>
			<!-- /wp:heading -->
			<!-- wp:group {"className":"num-steps","layout":{"type":"constrained"}} -->
			<div class="wp-block-group num-steps">
				<?php foreach ( $d['process'] as $index => $step ) : ?>
				<!-- wp:group {"className":"num-step","layout":{"type":"constrained"}} -->
				<div class="wp-block-group num-step">
					<!-- wp:paragraph {"className":"num-n"} -->
					<p class="num-n"><?php echo esc_html( (string) ( $index + 1 ) ); ?></p>
					<!-- /wp:paragraph -->
					<!-- wp:group {"className":"num-step-body","layout":{"type":"constrained"}} -->
					<div class="wp-block-group num-step-body">
						<!-- wp:heading {"level":4} -->
						<h4 class="wp-block-heading"><?php echo esc_html( $step[0] ); ?></h4>
						<!-- /wp:heading -->
						<!-- wp:paragraph -->
						<p><?php echo esc_html( $step[1] ); ?></p>
						<!-- /wp:paragraph -->
					</div>
					<!-- /wp:group -->
				</div>
				<!-- /wp:group -->
				<?php endforeach; ?>
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:column -->
		<!-- wp:column {"className":"reveal warranty-card"} -->
		<div class="wp-block-column reveal warranty-card">
			<!-- wp:paragraph {"className":"sec-label warranty-label"} -->
			<p class="sec-label warranty-label">The Cool Air Warranty</p>
			<!-- /wp:paragraph -->
			<!-- wp:heading {"level":3,"className":"warranty-title"} -->
			<h3 class="wp-block-heading warranty-title">Your Service Is Fully Protected</h3>
			<!-- /wp:heading -->
			<!-- wp:list {"className":"bullets-list light"} -->
			<ul class="bullets-list light">
				<li>1-year full parts and labor warranty</li>
				<li>30-day maintenance warranty</li>
				<li>Same issue recurs = free fix</li>
				<li>All parts new and unboxed onsite</li>
			</ul>
			<!-- /wp:list -->
			<!-- wp:buttons {"className":"warranty-acts"} -->
			<div class="wp-block-buttons warranty-acts">
				<!-- wp:button {"className":"btn-green"} -->
				<div class="wp-block-button btn-green"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">Schedule Now -&gt;</a></div>
				<!-- /wp:button -->
				<!-- wp:button {"className":"btn-green-call"} -->
				<div class="wp-block-button btn-green-call"><a class="wp-block-button__link wp-element-button" href="tel:<?php echo esc_attr( CA_PHONE_RAW ); ?>">Call or Text</a></div>
				<!-- /wp:button -->
			</div>
			<!-- /wp:buttons -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->
</section>
<!-- /wp:group -->

<!-- wp:group {"tagName":"section","className":"cta-section","layout":{"type":"constrained"}} -->
<section class="wp-block-group cta-section">
	<!-- wp:group {"className":"content-in","layout":{"type":"constrained"}} -->
	<div class="wp-block-group content-in">
		<!-- wp:heading {"textAlign":"center","level":2,"className":"sec-title light center"} -->
		<h2 class="wp-block-heading has-text-align-center sec-title light center">Schedule Your Service Today</h2>
		<!-- /wp:heading -->
		<!-- wp:paragraph {"align":"center","className":"sec-sub light center mx-auto"} -->
		<p class="has-text-align-center sec-sub light center mx-auto">Available 24/7, 365 days a year. You will always speak to a live agent.</p>
		<!-- /wp:paragraph -->
		<!-- wp:buttons {"className":"cta-acts","layout":{"type":"flex","justifyContent":"center"}} -->
		<div class="wp-block-buttons cta-acts">
			<!-- wp:button {"className":"btn-green"} -->
			<div class="wp-block-button btn-green"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">Book Online -&gt;</a></div>
			<!-- /wp:button -->
			<!-- wp:button {"className":"btn-green-call"} -->
			<div class="wp-block-button btn-green-call"><a class="wp-block-button__link wp-element-button" href="tel:<?php echo esc_attr( CA_PHONE_RAW ); ?>">Call or Text <?php echo esc_html( CA_PHONE ); ?></a></div>
			<!-- /wp:button -->
		</div>
		<!-- /wp:buttons -->
	</div>
	<!-- /wp:group -->
</section>
<!-- /wp:group -->
	<?php
	return trim( ob_get_clean() );
}

/**
 * Build non-service pages from existing renderers and migrate away from Classic.
 * This keeps layout parity while still replacing freeform/classic wrappers.
 */
function ca_render_about_page_builder_content() {
	return ca_wrap_editable_content_block( ca_render_about_page() );
}
function ca_render_contact_page_builder_content() {
	return ca_wrap_editable_content_block( ca_render_contact_page() );
}
function ca_render_membership_page_builder_content() {
	return ca_wrap_editable_content_block( ca_render_membership_page() );
}
function ca_render_financing_page_builder_content() {
	return ca_wrap_editable_content_block( ca_render_financing_page() );
}
function ca_render_careers_page_builder_content() {
	return ca_wrap_editable_content_block( ca_render_careers_page() );
}
function ca_render_specials_page_builder_content() {
	return ca_wrap_editable_content_block( ca_render_specials_page() );
}
function ca_render_brands_page_builder_content() {
	return ca_wrap_editable_content_block( ca_render_brands_page() );
}
function ca_render_service_areas_page_builder_content() {
	return ca_wrap_editable_content_block( ca_render_service_areas_page() );
}
function ca_render_legal_page_builder_content( $kind = 'privacy' ) {
	return ca_wrap_editable_content_block( ca_render_legal_page( [ 'kind' => $kind ] ) );
}
