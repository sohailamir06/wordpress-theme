<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'admin_post_ca_contact_request', 'ca_handle_contact_request' );
add_action( 'admin_post_nopriv_ca_contact_request', 'ca_handle_contact_request' );

/**
 * Handle contact form submissions from the Contact page.
 *
 * @return void
 */
function ca_handle_contact_request() {
	$redirect = wp_get_referer();
	if ( ! $redirect ) {
		$redirect = home_url( '/contact/' );
	}

	if ( ! isset( $_POST['ca_contact_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['ca_contact_nonce'] ) ), 'ca_contact_request' ) ) {
		wp_safe_redirect( add_query_arg( 'contact-status', 'invalid', $redirect ) );
		exit;
	}

	// Honeypot field. Real users never see or fill this input.
	if ( ! empty( $_POST['website'] ) ) {
		wp_safe_redirect( add_query_arg( 'contact-status', 'success', $redirect ) );
		exit;
	}

	$name    = isset( $_POST['name'] ) ? sanitize_text_field( wp_unslash( $_POST['name'] ) ) : '';
	$phone   = isset( $_POST['phone'] ) ? sanitize_text_field( wp_unslash( $_POST['phone'] ) ) : '';
	$email   = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
	$service = isset( $_POST['service'] ) ? sanitize_text_field( wp_unslash( $_POST['service'] ) ) : '';
	$message = isset( $_POST['message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['message'] ) ) : '';

	if ( '' === $name || '' === $phone || ! is_email( $email ) ) {
		wp_safe_redirect( add_query_arg( 'contact-status', 'missing', $redirect ) );
		exit;
	}

	$to      = get_option( 'admin_email' );
	$subject = sprintf( 'New service request from %s', $name );
	$body    = implode(
		"\n",
		[
			'New Cool Air USA contact request:',
			'',
			'Name: ' . $name,
			'Phone: ' . $phone,
			'Email: ' . $email,
			'Service: ' . $service,
			'',
			'Message:',
			$message,
		]
	);
	$headers = [ 'Reply-To: ' . $name . ' <' . $email . '>' ];

	$sent   = wp_mail( $to, $subject, $body, $headers );
	$status = $sent ? 'success' : 'failed';

	wp_safe_redirect( add_query_arg( 'contact-status', $status, $redirect ) );
	exit;
}
