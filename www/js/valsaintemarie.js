(function ($) {
	'use strict';
	window.valsaintemarie = (function ($) {
		return {
			onload: []
		}
	})($);
	$(function () {
		$.each(valsaintemarie.onload, function (idx, el) {
			el($);
		});
	});
})(jQuery);
