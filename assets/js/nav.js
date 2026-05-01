(function () {
	'use strict';

	function initNav() {
		var dropdowns = document.querySelectorAll('[data-dropdown]');
		var closeTimer = null;

		dropdowns.forEach(function (item) {
			item.addEventListener('mouseenter', function () {
				if (closeTimer) { clearTimeout(closeTimer); closeTimer = null; }
				dropdowns.forEach(function (d) { if (d !== item) d.classList.remove('open'); });
				item.classList.add('open');
			});
			item.addEventListener('mouseleave', function () {
				if (closeTimer) clearTimeout(closeTimer);
				closeTimer = setTimeout(function () {
					item.classList.remove('open');
				}, 180);
			});
			var btn = item.querySelector('.nav-btn');
			if (btn) {
				btn.addEventListener('click', function (e) {
					e.preventDefault();
					var open = item.classList.contains('open');
					dropdowns.forEach(function (d) { d.classList.remove('open'); });
					if (!open) item.classList.add('open');
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

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', function () { initNav(); initMobile(); });
	} else {
		initNav();
		initMobile();
	}
})();
