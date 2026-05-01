<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function ca_section_reviews() {
	$reviews   = ca_reviews();
	$dist      = [ [5,92], [4,6], [3,1], [2,0.5], [1,0.5] ];
	$platforms = [
		[ 'Google',   '4.9 ★',          '#4285f4' ],
		[ 'BBB',      'A+ Accredited',  '#003a70' ],
		[ 'Facebook', '4.9 ★',          '#1877f2' ],
	];
	$tags = [
		[ 'On Time',       '1,840+' ],
		[ 'Professional',  '2,210+' ],
		[ 'Fair Price',    '1,560+' ],
		[ 'Same Day',      '1,290+' ],
		[ 'Honest',        '980+'   ],
		[ 'Knowledgeable', '1,420+' ],
	];
	ob_start(); ?>
	<section id="reviews" class="reviews-section">
		<div class="sec-in">
			<div class="reveal reviews-head">
				<div class="sec-label">Reviews</div>
				<h2 class="sec-title">South Florida's Highest Rated</h2>
				<p class="sec-sub">Real reviews from real neighbors — verified across Google, BBB, Yelp, and Facebook.</p>
			</div>

			<div class="reveal reviews-summary">
				<div class="reviews-summary-rating">
					<?php echo ca_google_g_svg( 44 ); ?>
					<div>
						<div class="reviews-rating-row">
							<span class="reviews-rating-num">4.9</span>
							<div>
								<div class="reviews-rating-stars">★★★★★</div>
								<div class="reviews-rating-sub">4,600+ Google Reviews</div>
							</div>
						</div>
					</div>
				</div>
				<div class="reviews-distribution">
					<?php foreach ( $dist as $row ) : ?>
						<div class="reviews-dist-row">
							<span class="reviews-dist-star"><?php echo $row[0]; ?></span>
							<span class="reviews-dist-icon">★</span>
							<div class="reviews-dist-bar">
								<div class="reviews-dist-fill<?php echo $row[0] === 5 ? ' is-top' : ''; ?>" style="width: <?php echo $row[1]; ?>%;"></div>
							</div>
							<span class="reviews-dist-pct"><?php echo $row[1]; ?>%</span>
						</div>
					<?php endforeach; ?>
				</div>
				<div class="reviews-platforms">
					<?php foreach ( $platforms as $p ) : ?>
						<div class="reviews-platform">
							<span class="reviews-platform-dot" style="background: <?php echo esc_attr( $p[2] ); ?>;"></span>
							<span class="reviews-platform-name"><?php echo esc_html( $p[0] ); ?></span>
							<span class="reviews-platform-val"><?php echo esc_html( $p[1] ); ?></span>
						</div>
					<?php endforeach; ?>
				</div>
			</div>

			<div class="reveal reviews-tags">
				<span class="reviews-tags-lead">Most mentioned:</span>
				<?php foreach ( $tags as $t ) : ?>
					<div class="reviews-tag">
						<span class="reviews-tag-name"><?php echo esc_html( $t[0] ); ?></span>
						<span class="reviews-tag-count"><?php echo esc_html( $t[1] ); ?></span>
					</div>
				<?php endforeach; ?>
			</div>

			<div class="reviews-grid">
				<?php foreach ( $reviews as $i => $r ) : ?>
					<article class="review-card reveal d<?php echo ( $i % 4 ) + 1; ?>">
						<div class="review-head">
							<div class="review-avatar"><?php echo esc_html( $r['initials'] ); ?></div>
							<div class="review-meta">
								<div class="review-name-row">
									<span class="review-name"><?php echo esc_html( $r['name'] ); ?></span>
									<span class="review-verified" title="Verified">✓</span>
								</div>
								<div class="review-loc"><?php echo esc_html( $r['city'] ); ?> · Local Guide</div>
							</div>
							<?php echo ca_google_g_svg( 18 ); ?>
						</div>
						<div class="review-stars-row">
							<span class="review-stars">★★★★★</span>
							<span class="review-date"><?php echo esc_html( $r['date'] ); ?></span>
						</div>
						<p class="review-text"><?php echo esc_html( $r['text'] ); ?></p>
						<div class="review-foot">
							<span>👍 Helpful · <?php echo 12 + ( $i * 7 ) % 40; ?></span>
							<span>↪ Share</span>
							<span class="review-recommends">Recommends Cool Air USA</span>
						</div>
					</article>
				<?php endforeach; ?>
			</div>

			<div class="reviews-cta">
				<a class="btn-navy-cta" href="https://www.google.com/search?q=cool+air+usa+reviews" target="_blank" rel="noopener">
					<?php echo ca_google_g_svg( 16 ); ?> Read All 4,600+ Reviews on Google →
				</a>
				<a class="btn-write-review" href="https://www.google.com/search?q=cool+air+usa" target="_blank" rel="noopener">
					★ Write a Review
				</a>
			</div>
		</div>
	</section>
	<?php
	return ob_get_clean();
}

function ca_google_g_svg( $size = 20 ) {
	return '<svg width="' . intval( $size ) . '" height="' . intval( $size ) . '" viewBox="0 0 48 48">' .
		'<path fill="#4285f4" d="M24 9.5c3.5 0 6.6 1.2 9 3.4l6.7-6.7C35.6 2.4 30.1 0 24 0 14.6 0 6.5 5.4 2.5 13.3l7.8 6.1C12.2 13.5 17.6 9.5 24 9.5z"/>' .
		'<path fill="#34a853" d="M46.5 24.5c0-1.6-.1-3.1-.4-4.5H24v9h12.7c-.6 3-2.3 5.5-4.9 7.2l7.6 5.9c4.4-4.1 7.1-10.1 7.1-17.6z"/>' .
		'<path fill="#fbbc04" d="M10.3 28.6c-.5-1.5-.8-3-.8-4.6s.3-3.1.8-4.6l-7.8-6.1C.9 16.6 0 20.2 0 24s.9 7.4 2.5 10.7l7.8-6.1z"/>' .
		'<path fill="#ea4335" d="M24 48c6.1 0 11.3-2 15.1-5.5l-7.6-5.9c-2.1 1.4-4.7 2.2-7.5 2.2-6.4 0-11.8-4-13.7-9.9l-7.8 6.1C6.5 42.6 14.6 48 24 48z"/>' .
		'</svg>';
}
