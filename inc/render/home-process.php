<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function ca_section_process() {
	$steps = [
		[ 'Call or Book Online',  "Reach us at " . CA_PHONE . " or book online. We're open 24/7/365 — a real person in our office answers, never a machine." ],
		[ 'Tech Arrives Fast',    'A certified, factory-trained technician arrives in a fully stocked van — typically within hours, ready to diagnose and fix.' ],
		[ 'Clear Flat-Rate Quote',"We explain what's wrong in plain English and give a flat-rate price before any work begins. No surprises." ],
		[ 'Problem Solved',       'Repair done, system tested, invoice emailed with before & after photos. Comfort restored — guaranteed.' ],
	];
	ob_start(); ?>
	<section class="section process-section" data-process>
		<div class="sec-in">
			<div class="reveal process-head">
				<div class="sec-label">Simple &amp; Transparent</div>
				<h2 class="sec-title">From Call to Cool in 4 Steps</h2>
				<p class="sec-sub">We make it easy. Here's exactly what happens the moment you reach out.</p>
			</div>
			<div class="process-road">
				<div class="process-road-base"></div>
				<div class="process-road-fill" data-process-fill></div>
				<div class="process-road-dashed"></div>
				<div class="process-van-wrap">
					<div class="process-van" data-process-van>
						<svg width="56" height="42" viewBox="0 0 56 42">
							<rect x="6" y="10" width="38" height="20" rx="3" fill="#1a3a5c"/>
							<path d="M 44 14 L 52 18 L 52 30 L 44 30 Z" fill="#0ea5e9"/>
							<rect x="9" y="13" width="11" height="6" rx="1" fill="#bae6fd" opacity=".85"/>
							<rect x="22" y="13" width="11" height="6" rx="1" fill="#bae6fd" opacity=".85"/>
							<path d="M 45 16 L 51 19 L 51 24 L 45 24 Z" fill="#bae6fd" opacity=".85"/>
							<rect x="6" y="22" width="38" height="3" fill="#22c55e"/>
							<text x="9" y="28" font-family="Barlow Condensed,sans-serif" font-size="5" font-weight="800" fill="#fff" letter-spacing=".3">COOL AIR USA</text>
							<circle cx="14" cy="33" r="5" fill="#0f172a"/>
							<circle cx="14" cy="33" r="2" fill="#475569"/>
							<circle cx="42" cy="33" r="5" fill="#0f172a"/>
							<circle cx="42" cy="33" r="2" fill="#475569"/>
							<circle cx="52" cy="22" r="2" fill="#fde68a" opacity=".9">
								<animate attributeName="opacity" values=".5;1;.5" dur="1s" repeatCount="indefinite"/>
							</circle>
						</svg>
					</div>
				</div>
			</div>
			<div class="process-grid">
				<?php foreach ( $steps as $i => $st ) : ?>
					<div class="proc-step reveal d<?php echo $i + 1; ?>" data-step="<?php echo $i; ?>">
						<div class="proc-num"><?php echo $i + 1; ?></div>
						<div class="proc-title"><?php echo esc_html( $st[0] ); ?></div>
						<p class="proc-desc"><?php echo esc_html( $st[1] ); ?></p>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
	<?php
	return ob_get_clean();
}
