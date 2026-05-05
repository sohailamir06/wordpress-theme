(function () {
	'use strict';

	function initNav() {
		var dropdowns = document.querySelectorAll('[data-dropdown]');
		var closeTimer = null;

		dropdowns.forEach(function (item) {
			item.addEventListener('mouseenter', function (e) {
				if (closeTimer) { clearTimeout(closeTimer); closeTimer = null; }
				
				// Only close siblings, not ancestors
				var siblings = item.parentElement.querySelectorAll(':scope > [data-dropdown]');
				siblings.forEach(function (s) { if (s !== item) s.classList.remove('open'); });
				
				item.classList.add('open');
				e.stopPropagation();
			});

			item.addEventListener('mouseleave', function () {
				if (closeTimer) clearTimeout(closeTimer);
				closeTimer = setTimeout(function () {
					item.classList.remove('open');
				}, 180);
			});

			var btn = item.querySelector('.nav-btn, .nav-dd-item');
			if (btn && btn.parentElement === item) {
				btn.addEventListener('click', function (e) {
					if (item.classList.contains('has-submenu') || item.parentElement.classList.contains('nav-links')) {
						e.preventDefault();
						e.stopPropagation();
						var open = item.classList.contains('open');
						
						// Only close siblings
						var siblings = item.parentElement.querySelectorAll(':scope > [data-dropdown]');
						siblings.forEach(function (d) { d.classList.remove('open'); });
						
						if (!open) item.classList.add('open');
					}
				});
			}
		});

		document.addEventListener('click', function (e) {
			if (!e.target.closest('[data-dropdown]')) {
				dropdowns.forEach(function (d) { d.classList.remove('open'); });
			}
		});
	}

	function initMobile() {
		var toggle = document.querySelector('[data-mobile-toggle]');
		var menu = document.querySelector('[data-mobile-menu]');
		if (!toggle || !menu) return;
		toggle.addEventListener('click', function () {
			menu.classList.toggle('open');
		});
		menu.querySelectorAll('a').forEach(function (a) {
			a.addEventListener('click', function () { menu.classList.remove('open'); });
		});
	}

	function initScroll() {
		var header = document.querySelector('[data-site-header]');
		if (!header) return;

		function handleScroll() {
			if (window.scrollY > 40) {
				header.classList.add('is-scrolled');
			} else {
				header.classList.remove('is-scrolled');
			}
		}

		window.addEventListener('scroll', handleScroll, { passive: true });
		handleScroll(); // Initial check
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', function () { 
			initNav(); 
			initMobile(); 
			initScroll();
		});
	} else {
		initNav();
		initMobile();
		initScroll();
	}
})();
