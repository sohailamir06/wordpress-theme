<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function ca_render_legal_page( $attrs ) {
	$kind = ! empty( $attrs['kind'] ) ? $attrs['kind'] : 'privacy';
	$slug = get_post_field( 'post_name', get_queried_object_id() );
	if ( strpos( $slug, 'terms' ) !== false ) $kind = 'terms';
	if ( strpos( $slug, 'privacy' ) !== false ) $kind = 'privacy';

	if ( $kind === 'terms' ) {
		return ca_render_terms_page();
	}
	return ca_render_privacy_page();
}

function ca_render_privacy_page() {
	$sections = [
		[ 'Information We Collect', 'We collect information you provide directly: name, address, phone, email, and details about your home or business HVAC and plumbing systems. We also collect technical data such as IP address and browser type when you visit our website.' ],
		[ 'How We Use Information', 'We use your information to schedule and provide service, follow up on appointments, send maintenance reminders, process payments, and respond to inquiries. We never sell your personal information to third parties.' ],
		[ 'Information Sharing',    'We share information only with service partners necessary to deliver our services (payment processors, scheduling software, parts suppliers). All partners are bound by data protection requirements.' ],
		[ 'Data Security',          'We protect your data using industry-standard security measures including encryption in transit, secure storage, and access controls. No method of transmission is 100% secure but we follow best practices.' ],
		[ 'Your Rights',            'You may request a copy of your data, request corrections, or request deletion at any time by contacting us at ' . CA_EMAIL . '.' ],
		[ 'Cookies',                'Our website uses cookies to remember preferences and analyze site usage. You can disable cookies in your browser settings.' ],
		[ 'Contact',                'Privacy questions? Email ' . CA_EMAIL . ' or call ' . CA_PHONE . '.' ],
	];
	return ca_render_legal_doc( 'Privacy Policy', 'Last updated: January 2026', $sections );
}

function ca_render_terms_page() {
	$sections = [
		[ 'Service Agreement',   "By scheduling service with Cool Air USA you agree to these terms. All work is performed by licensed and insured technicians under license CAC1816920." ],
		[ 'Pricing &amp; Payment',  "All pricing is flat-rate and provided in writing before any work begins. Payment is due upon completion. We accept cash, all major credit cards, and approved financing." ],
		[ 'Warranty',            'Repairs include a 1-year parts &amp; labor warranty. Installations include a 1-year labor warranty plus the manufacturer\'s parts warranty (typically 5–10 years).' ],
		[ 'Cancellations',       'Same-day cancellations may incur a dispatch fee. Rescheduling 24+ hours in advance is always free.' ],
		[ 'Limitation of Liability', "Cool Air USA's liability is limited to the amount paid for the specific service. We are not liable for indirect or consequential damages." ],
		[ 'Dispute Resolution',  'Any disputes will be resolved by binding arbitration in Broward County, Florida.' ],
		[ 'Modifications',       'We may update these terms periodically. Continued use of our services after changes constitutes acceptance of the updated terms.' ],
	];
	return ca_render_legal_doc( 'Terms of Service', 'Last updated: January 2026', $sections );
}

function ca_render_legal_doc( $title, $updated, $sections ) {
	ob_start(); ?>
	<div class="ca-legal">
		<?php echo ca_page_hero( $title, $title, $updated ); ?>
		<section class="content-section">
			<div class="content-in legal-doc">
				<?php foreach ( $sections as $s ) : ?>
					<div class="legal-section reveal">
						<h3 class="legal-h3"><?php echo esc_html( $s[0] ); ?></h3>
						<p><?php echo wp_kses_post( $s[1] ); ?></p>
					</div>
				<?php endforeach; ?>
			</div>
		</section>
	</div>
	<?php
	return ob_get_clean();
}
