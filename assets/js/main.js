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
		// Load each module — they self-register listeners.
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
		var root = document.querySelector('[data-stats-rotator]');
		if (!root) return;
		var track = root.querySelector('.stats-slider-track');
		var slides = root.querySelectorAll('.stats-slide');
		var dots = root.querySelectorAll('.stats-dot');
		var prev = root.querySelector('.stats-arrow-l');
		var next = root.querySelector('.stats-arrow-r');
		var idx = 0;
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

		start();
	}

	// Process section: van animation + step highlighting on scroll
	function initProcessSection() {
		var section = document.querySelector('[data-process]');
		if (!section) return;
		var van = section.querySelector('[data-process-van]');
		var fill = section.querySelector('[data-process-fill]');
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
			update(0);
			var i = 0;
			timer = setInterval(function () {
				i = (i + 1) % 4;
				update(i);
			}, 2200);
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
		var cards = document.querySelectorAll('[data-tilt], [data-tilt-soft]');
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

	// 3D rotating gallery (Lazy-Susan)
	function initGallery() {
		var stage = document.querySelector('[data-gallery]');
		if (!stage) return;
		var cards = stage.querySelectorAll('[data-gallery-card]');
		var dots = stage.querySelectorAll('.gallery-dot');
		var arrL = stage.querySelector('.gallery-arrow-l');
		var arrR = stage.querySelector('.gallery-arrow-r');
		var n = cards.length;
		if (!n) return;

		var idx = 0;
		var paused = false;
		var auto = null;

		function position() {
			cards.forEach(function (card, i) {
				var rel = ((i - idx) + n) % n;
				if (rel > n / 2) rel -= n;
				var abs = Math.abs(rel);
				var translateX = rel * 220;
				var rotateY = rel * -22;
				var z = abs * -120;
				var opacity = abs > 3 ? 0 : 1 - abs * 0.18;
				var scale = 1 - abs * 0.08;
				card.style.transform = 'translateX(' + translateX + 'px) translateZ(' + z + 'px) rotateY(' + rotateY + 'deg) scale(' + scale + ')';
				card.style.opacity = opacity;
				card.style.zIndex = 100 - abs;
				card.classList.toggle('is-front', rel === 0);
			});
			dots.forEach(function (d, di) { d.classList.toggle('active', di === idx); });
		}

		function go(i) { idx = (i + n) % n; position(); }
		function startAuto() {
			stopAuto();
			auto = setInterval(function () { if (!paused) go(idx + 1); }, 3500);
		}
		function stopAuto() { if (auto) clearInterval(auto); auto = null; }

		cards.forEach(function (card, i) {
			card.addEventListener('click', function () { go(i); startAuto(); });
		});
		dots.forEach(function (d, di) {
			d.addEventListener('click', function () { go(di); startAuto(); });
		});
		if (arrL) arrL.addEventListener('click', function () { go(idx - 1); startAuto(); });
		if (arrR) arrR.addEventListener('click', function () { go(idx + 1); startAuto(); });
		stage.addEventListener('mouseenter', function () { paused = true; });
		stage.addEventListener('mouseleave', function () { paused = false; });
		document.addEventListener('keydown', function (e) {
			var rect = stage.getBoundingClientRect();
			if (rect.bottom < 0 || rect.top > window.innerHeight) return;
			if (e.key === 'ArrowLeft')  go(idx - 1);
			if (e.key === 'ArrowRight') go(idx + 1);
		});

		position();
		startAuto();
	}

	// Contact form: simulated submit (real handler is server-side via wp-admin/admin-post.php)
	function initContactForm() {
		var form = document.querySelector('[data-contact-form]');
		if (!form) return;
		var success = form.querySelector('[data-form-success]');
		form.addEventListener('submit', function (e) {
			e.preventDefault();
			if (success) {
				success.hidden = false;
				form.querySelectorAll('input, select, textarea, button').forEach(function (el) { el.disabled = true; });
			}
		});
	}
})();
