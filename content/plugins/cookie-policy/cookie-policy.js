/*
 * jQuery Reveal Plugin 1.0
 * www.ZURB.com
 * Copyright 2010, ZURB
 * Free to use under the MIT license.
 * http://www.opensource.org/licenses/mit-license.php
 */
(function ($) {
	$('a[data-reveal-id]').on('click', function (event) {
		event.preventDefault();
		var modalLocation = $(this).attr('data-reveal-id');
		$('#' + modalLocation).reveal($(this).data());
	});

	$.fn.reveal = function (options) {
		var defaults = {
			animation: 'fadeAndPop',
			animationSpeed: 300,
			closeOnBackgroundClick: true,
			dismissModalClass: 'close-reveal-modal'
		};
		var options = $.extend({}, defaults, options);

		return this.each(function () {
			var modal = $(this),
				topMeasure = parseInt(modal.css('top')),
				topOffset = modal.height() + topMeasure,
				locked = false,
				modalBg = $('.reveal-modal-bg');

			if (modalBg.length == 0) {
				modalBg = $('<div class="reveal-modal-bg" />').insertAfter(modal);
				modalBg.fadeTo('fast', 0.8);
			}

			function openAnimation() {
				modalBg.unbind('click.modalEvent');
				$('.' + options.dismissModalClass).unbind('click.modalEvent');
				if (!locked) {
					lockModal();
					if (options.animation == "fadeAndPop") {
						modal.css({'top': $(document).scrollTop() - topOffset, 'opacity': 0, 'visibility': 'visible'});
						modalBg.fadeIn(options.animationSpeed / 2);
						modal.delay(options.animationSpeed / 2).animate({
							"top": $(document).scrollTop() + topMeasure + 'px',
							"opacity": 1
						}, options.animationSpeed, unlockModal);
					}
					if (options.animation == "fade") {
						modal.css({'opacity': 0, 'visibility': 'visible', 'top': $(document).scrollTop() + topMeasure});
						modalBg.fadeIn(options.animationSpeed / 2);
						modal.delay(options.animationSpeed / 2).animate({
							"opacity": 1
						}, options.animationSpeed, unlockModal);
					}
					if (options.animation == "none") {
						modal.css({'visibility': 'visible', 'top': $(document).scrollTop() + topMeasure});
						modalBg.css({"display": "block"});
						unlockModal();
					}
				}
				modal.unbind('reveal:open', openAnimation);
			}

			modal.bind('reveal:open', openAnimation);

			function closeAnimation() {
				if (!locked) {
					lockModal();
					if (options.animation == "fadeAndPop") {
						modalBg.delay(options.animationSpeed).fadeOut(options.animationSpeed);
						modal.animate({
							"top": $(document).scrollTop() - topOffset + 'px',
							"opacity": 0
						}, options.animationSpeed / 2, function () {
							modal.css({'top': topMeasure, 'opacity': 1, 'visibility': 'hidden'});
							unlockModal();
						});
					}
					if (options.animation == "fade") {
						modalBg.delay(options.animationSpeed).fadeOut(options.animationSpeed);
						modal.animate({
							"opacity": 0
						}, options.animationSpeed, function () {
							modal.css({'opacity': 1, 'visibility': 'hidden', 'top': topMeasure});
							unlockModal();
						});
					}
					if (options.animation == "none") {
						modal.css({'visibility': 'hidden', 'top': topMeasure});
						modalBg.css({'display': 'none'});
					}
				}
				modal.unbind('reveal:close', closeAnimation);
			}

			modal.bind('reveal:close', closeAnimation);
			modal.trigger('reveal:open');

			var closeButton = $('.' + options.dismissModalClass).bind('click.modalEvent', function () {
				modal.trigger('reveal:close');
			});

			if (options.closeOnBackgroundClick) {
				modalBg.css({"cursor": "pointer"});
				modalBg.bind('click.modalEvent', function () {
					modal.trigger('reveal:close');
				});
			}

			$('body').keyup(function (event) {
				if (event.which === 27) { // 27 is the keycode for the Escape key
					modal.trigger('reveal:close');
				}
			});

			function unlockModal() {
				locked = false;
			}

			function lockModal() {
				locked = true;
			}
		});
	};
})(jQuery);

/*
 * Cookie Policy Plugin 0.2
 */
(function ($, window, document, undefined) {
	function WHCreateCookie(name, value, days) {
		var date = new Date(),
			expires;

		date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
		expires = "; expires=" + date.toGMTString();

		document.cookie = name + "=" + value + expires + "; path=/";
	}

	function WHReadCookie(name) {
		var nameEQ = name + "=",
			ca = document.cookie.split(';'),
			i, c;

		for (i = 0; i < ca.length; i++) {
			c = ca[i];

			while (c.charAt(0) == ' ') {
				c = c.substring(1, c.length);
			}

			if (c.indexOf(nameEQ) == 0) {
				return c.substring(nameEQ.length, c.length);
			}
		}

		return null;
	}

	$(window).load(function () {
		if (WHReadCookie('cookies_accepted') != 'T') {
			$('#cookie-widget').show();
		}
	});

	$('#accept-cookies-checkbox').on('click', function (e) {
		e.preventDefault();

		WHCreateCookie('cookies_accepted', 'T', 365);
		$('#cookie-widget').hide();
	});
})(jQuery, window, document);
