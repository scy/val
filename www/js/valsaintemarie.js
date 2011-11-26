(function ($) {
	'use strict';
	// Things that should run on page load.
	var onload = [
		// Remember scroll position on choose6 pages.
		function ($) {
			var $div = $('body.choose6 #main');
			if (!$div.length) {
				return;
			}
			var name = 'scrollpos-' + $('body').attr('id');
			$div.scroll(function (ev) {
				$.cookie(name, $div.scrollLeft());
			});
			var value = $.cookie(name);
			if (value !== null && $div.scrollLeft() == 0) {
				$div.scrollLeft(value);
			}
		}
	];
	window.valsaintemarie = (function ($) {
		return {
			onload: onload
		}
	})($);
	$(function () {
		$.each(valsaintemarie.onload, function (idx, el) {
			el($);
		});
	});
})(jQuery);
