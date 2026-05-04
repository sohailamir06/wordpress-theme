(function () {
	'use strict';

	var ready = function (cb) {
		if (document.readyState === 'loading') {
			document.addEventListener('DOMContentLoaded', cb);
		} else {
			cb();
		}
	};

	ready(function () {
		// Load each module - they self-register listeners.
		initReveal();
		initParallax();
		initStatsRotator();
		initProcessSection();
		initTilt();
		initGallery();
		initContactForm();
	});

	// Scroll-reveal for elements with .reveal
	function initReveal() {
		var els = document.querySelectorAll('.reveal');
		if (!('IntersectionObserver' in window) || !els.length) {
			els.forEach(function (el) { el.classList.add('visible'); });
			return;
		}
		var obs = new IntersectionObserver(function (entries) {
			entries.forEach(function (e) {
				if (e.isIntersecting) {
					e.target.classList.add('visible');
					obs.unobserve(e.target);
				}
			});
		}, { threshold: 0.07, rootMargin: '0px 0px -40px 0px' });
		els.forEach(function (el) { obs.observe(el); });
	}

	// Hero parallax
	function initParallax() {
		var bg = document.querySelector('.hero-bg');
		if (!bg) return;
		var raf = null;
		window.addEventListener('scroll', function () {
			if (raf) return;
			raf = requestAnimationFrame(function () {
				bg.style.transform = 'translateY(' + (window.scrollY * 0.22) + 'px)';
				raf = null;
			});
		}, { passive: true });
	}

	// Rotating stats bar
	function initStatsRotator() {
		var root = document.querySelector('[data-stats-rotator]') || document.querySelector('.stats-bar');
		if (!root) return;
		var track = root.querySelector('.stats-slider-track');
		var slides = root.querySelectorAll('.stats-slide');
		var dots = root.querySelectorAll('.stats-dot');
		var prev = root.querySelector('.stats-arrow-l');
		var next = root.querySelector('.stats-arrow-r');
		if (!track || !slides.length) return;

		var idx = 0;
		var startClass = Array.prototype.find.call(root.classList, function (cls) {
			return cls.indexOf('stats-start-') === 0;
		});
		if (startClass) {
			var parsed = parseInt(startClass.replace('stats-start-', ''), 10);
			if (!isNaN(parsed) && parsed > 0 && parsed <= slides.length) {
				idx = parsed - 1;
			}
		}
		var paused = false;
		var timer = null;

		function go(i) {
			idx = (i + slides.length) % slides.length;
			track.style.transform = 'translateX(-' + (idx * 100) + '%)';
			dots.forEach(function (d, di) { d.classList.toggle('active', di === idx); });
		}
		function start() {
			stop();
			timer = setInterval(function () { if (!paused) go(idx + 1); }, 6000);
		}
		function stop() { if (timer) clearInterval(timer); timer = null; }

		dots.forEach(function (d, di) { d.addEventListener('click', function () { go(di); start(); }); });
		if (prev) prev.addEventListener('click', function () { go(idx - 1); start(); });
		if (next) next.addEventListener('click', function () { go(idx + 1); start(); });
		root.addEventListener('mouseenter', function () { paused = true; });
		root.addEventListener('mouseleave', function () { paused = false; });

		go(idx);
		start();
	}

	// Process section: animate vehicle, fill, and active step states.
	function initProcessSection() {
		var section = document.querySelector('[data-process]') || document.querySelector('.process-section') || document.querySelector('.proc-section');
		if (!section) return;
		var van = section.querySelector('[data-process-van]') || section.querySelector('.process-van') || section.querySelector('.proc-van');
		var fill = section.querySelector('[data-process-fill]') || section.querySelector('.process-road-fill') || section.querySelector('.proc-line-fill');
		var steps = section.querySelectorAll('.proc-step');
		if (!van || !steps.length) return;

		var active = 0;
		var started = false;
		var timer = null;

		function update(i) {
			active = i;
			van.style.left = ((i / 3) * 100) + '%';
			if (fill) fill.style.width = ((i / 3) * 100) + '%';
			steps.forEach(function (s, si) {
				s.classList.toggle('is-active', si === i);
				s.classList.toggle('is-past', si < i);
			});
		}

		function startCycle() {
			if (started) return;
			started = true;
			var parsedStart = parseInt(section.getAttribute('data-process-start') || '1', 10);
			var i = isNaN(parsedStart) ? 1 : Math.max(0, Math.min(steps.length - 1, parsedStart));
			update(i);
			timer = setInterval(function () {
				i = (i + 1) % steps.length;
				update(i);
			}, 2300);
		}

		if ('IntersectionObserver' in window) {
			var obs = new IntersectionObserver(function (entries) {
				entries.forEach(function (e) {
					if (e.isIntersecting) startCycle();
				});
			}, { threshold: 0.2 });
			obs.observe(section);
		} else {
			startCycle();
		}
	}

	// 3D tilt for cards with [data-tilt]
	function initTilt() {
		var cards = document.querySelectorAll('[data-tilt], [data-tilt-soft], .why-card');
		cards.forEach(function (card) {
			var soft = card.hasAttribute('data-tilt-soft');
			card.addEventListener('mousemove', function (e) {
				var r = card.getBoundingClientRect();
				var x = (e.clientX - r.left - r.width / 2) / (r.width / 2);
				var y = (e.clientY - r.top - r.height / 2) / (r.height / 2);
				var max = soft ? 4 : 10;
				card.style.transform =
					'perspective(700px) rotateX(' + (-y * max) + 'deg) rotateY(' + (x * max) + 'deg) translateZ(' + (soft ? 4 : 10) + 'px)';
				if (!soft) {
					card.style.boxShadow = (-x * 10) + 'px ' + (y * 10) + 'px 28px rgba(0,0,0,.12)';
				}
			});
			card.addEventListener('mouseleave', function () {
				card.style.transform = '';
				card.style.boxShadow = '';
			});
		});
	}

	// 3D coverflow gallery.
	function initGallery() {
		var galleries = document.querySelectorAll('[data-gallery]');
		if (!galleries.length) galleries = document.querySelectorAll('.gallery-section');
		if (!galleries.length) return;

		galleries.forEach(function (root) {
			var stage = root.querySelector('.gallery-stage') || root;
			var cards = root.querySelectorAll('[data-gallery-card], .gallery-card');
			var dots = root.querySelectorAll('.gallery-dot');
			var prev = root.querySelector('.gallery-arrow-l');
			var next = root.querySelector('.gallery-arrow-r');
			var toggle = root.querySelector('.gallery-toggle');
			var current = root.querySelector('[data-gallery-current]');
			var n = cards.length;
			if (!n) return;

			var idx = 0;
			var paused = false;
			var autoplay = root.getAttribute('data-gallery-autoplay') !== 'false';
			var timer = null;

			function pad(num) {
				return num < 10 ? '0' + num : String(num);
			}

			function signedDistance(i) {
				var rel = ((i - idx) + n) % n;
				if (rel > n / 2) rel -= n;
				return rel;
			}

			function position() {
				var stageWidth = stage.clientWidth || root.clientWidth || 1180;
				var cardWidth = cards[0].getBoundingClientRect().width || 420;
				var spread = Math.min(Math.max(stageWidth * 0.28, 155), cardWidth * 0.88);

				cards.forEach(function (card, i) {
					var rel = signedDistance(i);
					var abs = Math.abs(rel);
					var hidden = abs > 3;
					var depth = abs * -92;
					var rotate = rel * -34;
					var scale = abs === 0 ? 1.06 : Math.max(0.68, 0.9 - abs * 0.075);
					var offset = rel * spread * (abs > 1 ? 1.08 : 1);
					var opacity = hidden ? 0 : Math.max(0.18, 1 - abs * 0.19);

					card.style.transform = 'translateX(' + offset + 'px) translateZ(' + depth + 'px) rotateY(' + rotate + 'deg) scale(' + scale + ')';
					card.style.opacity = opacity;
					card.style.zIndex = String(120 - abs);
					card.setAttribute('aria-label', 'Project ' + pad(i + 1) + ' of ' + n);
					card.setAttribute('aria-current', rel === 0 ? 'true' : 'false');
					card.setAttribute('tabindex', rel === 0 || abs === 1 ? '0' : '-1');
					if (!card.getAttribute('role') && card.tagName.toLowerCase() !== 'button') {
						card.setAttribute('role', 'button');
					}
					card.classList.toggle('is-front', rel === 0);
					card.classList.toggle('is-side', abs > 0 && !hidden);
					card.classList.toggle('is-hidden', hidden);
				});

				dots.forEach(function (dot, di) {
					var active = di === idx;
					dot.classList.toggle('active', active);
					dot.setAttribute('aria-current', active ? 'true' : 'false');
				});

				if (current) current.textContent = pad(idx + 1);
			}

			function go(i) {
				idx = (i + n) % n;
				position();
			}

			function stopAuto() {
				if (timer) clearInterval(timer);
				timer = null;
			}

			function startAuto() {
				stopAuto();
				if (!autoplay) return;
				timer = setInterval(function () {
					if (!paused) go(idx + 1);
				}, 4000);
			}

			function setAutoplay(enabled) {
				autoplay = enabled;
				if (toggle) {
					toggle.classList.toggle('is-off', !enabled);
					toggle.setAttribute('aria-pressed', enabled ? 'true' : 'false');
					toggle.textContent = enabled ? 'Auto-Spin' : 'Paused';
				}
				startAuto();
			}

			cards.forEach(function (card, i) {
				card.addEventListener('click', function () {
					go(i);
					startAuto();
				});
				card.addEventListener('keydown', function (e) {
					if (e.key === 'Enter' || e.key === ' ') {
						e.preventDefault();
						go(i);
						startAuto();
					}
				});
			});

			dots.forEach(function (dot, di) {
				dot.addEventListener('click', function () {
					go(di);
					startAuto();
				});
			});

			if (prev) prev.addEventListener('click', function () { go(idx - 1); startAuto(); });
			if (next) next.addEventListener('click', function () { go(idx + 1); startAuto(); });
			if (toggle) toggle.addEventListener('click', function () { setAutoplay(!autoplay); });

			root.addEventListener('mouseenter', function () { paused = true; });
			root.addEventListener('mouseleave', function () { paused = false; });
			root.addEventListener('focusin', function () { paused = true; });
			root.addEventListener('focusout', function () { paused = false; });

			document.addEventListener('keydown', function (e) {
				var rect = root.getBoundingClientRect();
				if (rect.bottom < 0 || rect.top > window.innerHeight) return;
				if (e.key === 'ArrowLeft') {
					go(idx - 1);
					startAuto();
				}
				if (e.key === 'ArrowRight') {
					go(idx + 1);
					startAuto();
				}
			});

			window.addEventListener('resize', position, { passive: true });

			position();
			setAutoplay(autoplay);
		});
	}

	// Contact form: disable repeat submits while the server-side handler runs.
	function initContactForm() {
		var form = document.querySelector('[data-contact-form]');
		if (!form) return;
		form.addEventListener('submit', function () {
			var button = form.querySelector('[type="submit"]');
			if (button) {
				button.disabled = true;
				button.textContent = 'Submitting...';
			}
		});
	}
})();
