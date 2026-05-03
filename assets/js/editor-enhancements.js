(function () {
	'use strict';

	function bindEditorForms() {
		var forms = document.querySelectorAll('.editor-styles-wrapper form, .block-editor-block-list__layout form');
		forms.forEach(function (form) {
			if (form.dataset.editorBound === '1') return;
			form.dataset.editorBound = '1';

			form.addEventListener('submit', function (e) {
				e.preventDefault();
				e.stopPropagation();

				var note = form.querySelector('[data-editor-form-note]');
				if (!note) {
					note = document.createElement('div');
					note.className = 'editor-form-note';
					note.setAttribute('data-editor-form-note', '1');
					note.textContent = 'Editor preview mode: form submission is disabled here.';
					form.appendChild(note);
				}
			});
		});
	}

	function bindEditorStatsSliders() {
		var roots = document.querySelectorAll('.editor-styles-wrapper .stats-bar');
		roots.forEach(function (root) {
			if (root.dataset.editorStatsBound === '1') return;
			root.dataset.editorStatsBound = '1';

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

			function go(i) {
				idx = (i + slides.length) % slides.length;
				track.style.transform = 'translateX(-' + (idx * 100) + '%)';
				dots.forEach(function (d, di) {
					d.classList.toggle('active', di === idx);
				});
			}

			if (prev) prev.addEventListener('click', function () { go(idx - 1); });
			if (next) next.addEventListener('click', function () { go(idx + 1); });
			dots.forEach(function (d, di) {
				d.addEventListener('click', function () { go(di); });
			});

			go(idx);
		});
	}

	function boot() {
		bindEditorForms();
		bindEditorStatsSliders();
		var target = document.body;
		if (!target || typeof MutationObserver === 'undefined') return;
		var obs = new MutationObserver(function () {
			bindEditorForms();
			bindEditorStatsSliders();
		});
		obs.observe(target, { childList: true, subtree: true });
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', boot);
	} else {
		boot();
	}
})();
