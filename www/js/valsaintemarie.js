(function ($) {
	'use strict';
	// Things that should run on page load.
	var onload = [
		// Scroll magic for choose6 pages.
		function ($) {
			// Only do something on a scroll6 page.
			var $div = $('body.choose6 #main');
			if (!$div.length) {
				return;
			}
			// Set up cookie-based scroll position remembering.
			var name = 'scrollpos-' + $('body').attr('id');
			$div.scroll(function (ev) {
				// Update click-to-scroll arrows (defined below):
				updateArrows();
				$.cookie(name, $div.scrollLeft());
			});
			// If a scroll position exists and the content is not scrolled, do it.
			var value = $.cookie(name);
			if (value !== null && $div.scrollLeft() == 0) {
				$div.scrollLeft(value);
			}
			// Create click-to-scroll arrows.
			var $center = $('#center');
			var farRight = $center.width() - $div.width();
			var $left = $('<div class="scroll-arrow arrow-left" data-scrollto="0" />').data('active-class', 'arrow-left-active');
			var $right = $('<div class="scroll-arrow arrow-right" data-scrollto="' + farRight + '"/>').data('active-class', 'arrow-right-active');
			var $both = $left.add($right);
			// Bind click-to-scroll handler.
			$both.click(function (ev) {
				$div.animate({
					scrollLeft: $(this).attr('data-scrollto')
				}, 2000, 'easeInOutQuart');
			});
			// Bind hover handlers.
			$both.mouseover(function (ev) {
				var $this = $(this);
				$this.addClass($this.data('active-class'));
			});
			$both.mouseout(function (ev) {
				var $this = $(this);
				$this.removeClass($this.data('active-class'));
			});
			// Add arrows.
			$center.append($left).append($right);
			// Function to show/hide click-to-scroll arrows.
			var updateArrows = function () {
				var sl = $div.scrollLeft();
				if (sl === 0) {
					// Show “scroll right” button on the right.
					$left.hide();
					$right.show();
				} else if (sl === farRight) {
					// Show “scroll left” button on the left.
					$right.hide();
					$left.show();
				} else {
					// Remove the buttons.
					$both.hide();
				}
			};
			// Initialize arrows.
			updateArrows();
		}
	];
	window.valsaintemarie = (function ($) {
		return {
			onload: onload
		}
	})($);
	$.extend($.easing, {
		easeInOutQuart: function (x, t, b, c, d) {
			if ((t/=d/2) < 1) return c/2*t*t*t*t + b;
			return -c/2 * ((t-=2)*t*t*t - 2) + b;
		}
	});
	$(function () {
		$.each(valsaintemarie.onload, function (idx, el) {
			el($);
		});
	});
})(jQuery);
