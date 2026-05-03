<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function ca_render_contact_page() {
	$rows = [
		[ '&#128222;', 'Phone', '<a href="tel:' . CA_PHONE_RAW . '">' . CA_PHONE . '</a><br>24/7/365 &mdash; real people, never a machine.' ],
		[ '&#9993;&#65039;', 'Email', '<a href="mailto:' . esc_attr( CA_EMAIL ) . '">' . esc_html( CA_EMAIL ) . '</a><br>We reply within 1 business hour.' ],
		[ '&#128205;', 'Office', CA_ADDRESS . '<br>Drop-ins welcome 8am&ndash;6pm.' ],
		[ '&#128336;', 'Hours', 'Office: 7am&ndash;9pm Mon&ndash;Sat<br>Emergency dispatch: 24/7/365' ],
	];
	$service_options = [ 'AC Repair', 'AC Installation', 'AC Maintenance', 'Duct Services', 'Air Quality', 'Plumbing', 'Commercial', 'Emergency', 'Other' ];
	$contact_status  = isset( $_GET['contact-status'] ) ? sanitize_key( wp_unslash( $_GET['contact-status'] ) ) : '';

	ob_start(); ?>
	<div class="ca-contact">
		<?php echo ca_page_hero( 'Contact', 'Get In Touch', 'Schedule service, request a free estimate, or just ask a question. A real person from our Fort Lauderdale office will respond within an hour during business hours.', [ '24/7/365', 'Live Agents', 'Same-Day Service', 'Free Estimates' ] ); ?>

		<section class="content-section off">
			<div class="content-in">
				<div class="contact-grid">
					<div class="reveal">
						<div class="sec-label">Reach Us</div>
						<h2 class="sec-title">We're Always Here</h2>
						<div class="contact-info-card">
							<?php foreach ( $rows as $r ) : ?>
								<div class="contact-row">
									<div class="contact-icon"><?php echo wp_kses_post( $r[0] ); ?></div>
									<div class="contact-detail">
										<h4><?php echo esc_html( $r[1] ); ?></h4>
										<p><?php echo wp_kses_post( $r[2] ); ?></p>
									</div>
								</div>
							<?php endforeach; ?>
						</div>
					</div>
					<div class="reveal">
						<form class="form-card" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post" data-contact-form>
							<?php wp_nonce_field( 'ca_contact_request', 'ca_contact_nonce' ); ?>
							<input type="hidden" name="action" value="ca_contact_request">
							<div class="form-row ca-hp" aria-hidden="true">
								<label for="cf-website">Website</label>
								<input id="cf-website" name="website" type="text" tabindex="-1" autocomplete="off">
							</div>
							<div class="form-title">Schedule Service</div>
							<?php if ( 'success' === $contact_status ) : ?>
								<div class="form-submit-msg" data-form-success>Thanks &mdash; we'll be in touch shortly.</div>
							<?php elseif ( in_array( $contact_status, [ 'invalid', 'missing', 'failed' ], true ) ) : ?>
								<div class="form-submit-msg is-error">We could not submit the form. Please check the required fields or call <?php echo esc_html( CA_PHONE ); ?>.</div>
							<?php endif; ?>
							<div class="form-row">
								<label for="cf-name">Full Name</label>
								<input id="cf-name" name="name" type="text" required>
							</div>
							<div class="form-row">
								<label for="cf-phone">Phone Number</label>
								<input id="cf-phone" name="phone" type="tel" required>
							</div>
							<div class="form-row">
								<label for="cf-email">Email</label>
								<input id="cf-email" name="email" type="email" required>
							</div>
							<div class="form-row">
								<label for="cf-service">Service Needed</label>
								<select id="cf-service" name="service">
									<?php foreach ( $service_options as $opt ) : ?>
										<option><?php echo esc_html( $opt ); ?></option>
									<?php endforeach; ?>
								</select>
							</div>
							<div class="form-row">
								<label for="cf-message">Tell Us More</label>
								<textarea id="cf-message" name="message" rows="4"></textarea>
							</div>
							<button class="btn-green form-submit" type="submit">Submit Request &rarr;</button>
						</form>
					</div>
				</div>
			</div>
		</section>

		<?php echo ca_section_emergency(); ?>
	</div>
	<?php
	return ob_get_clean();
}
