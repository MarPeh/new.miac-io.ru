/**!
 * РџР»Р°РіРёРЅ РґР»СЏ СЂРµР°Р»РёР·Р°С†РёРё РїРѕР»РЅРѕСЌРєСЂР°РЅРЅРѕРіРѕ РјРµРЅСЋ РёР· СЃСѓС‰РµСЃС‚РІСѓСЋС‰РµРіРѕ РЅР° СЃС‚Р°СЂРЅРёС†Рµ РєРѕРґР°
 * @link https://github.com/pafnuty/SimpleMobileNav
 * @date 09.10.2015
 * @version 1.0.1
 * 
 */
(function ($, window, document) {
	'use strict';
	var pluginName = 'simpleMobileNav',
		previousResizeWidth = 0,
		$body = $('body'),
		$window = $(window),
		defaults = {
			// РЎРµР»РµРєС‚РѕСЂ, СѓРєР°Р·С‹РІР°СЋС‰РёР№ РЅР° Р±Р»РѕРє, РёР· РєРѕС‚РѕСЂРѕРіРѕ Р±СѓРґСѓС‚ РІР·СЏС‚С‹ РїСѓРЅРєС‚С‹ РјРµРЅСЋ
			navBlock: '.nav',
			// РЎРµР»РµРєС‚РѕСЂ, СѓРєР°Р·С‹РІР°СЋС‰РёР№ РЅР° Р±Р»РѕРє, РєСѓРґР° Р±СѓРґСѓС‚ РїРѕРјРµС‰РµРЅС‹ РїСѓРЅРєС‚С‹ РјРµРЅСЋ
			navContainer: '.mobile-nav',
			// РЎРµР»РµРєС‚РѕСЂ, СѓРєР°Р·С‹РІР°СЋС‰РёР№ РЅР° Р±Р»РѕРє, РєРѕС‚РѕСЂС‹Р№ Рё Р±СѓРґРµС‚ РїРѕР»РЅРѕСЌРєСЂР°РЅРЅС‹Рј РјРµРЅСЋ
			navWrapper: '.mobile-nav-wrapper',
			// РљРѕР»Р±СЌРєРё
			// РЎСЂР°Р±Р°С‚С‹РІР°РµС‚ РїСЂРё РёРЅРёС†РёР°Р»РёР·Р°С†РёРё РїР»Р°РіРёРЅР°
			onInit: function () {},
			// РЎСЂР°Р±Р°С‚С‹РІР°РµС‚ РїРѕСЃР»Рµ РѕС‚РєСЂС‹С‚РёСЏ Рё Р·Р°РєСЂС‹С‚РёСЏ РјРµРЅСЋ
			onNavToggle: function () {},
			// РЎСЂР°Р±Р°С‚С‹РІР°РµС‚ РїСЂРё РѕС‚РєСЂС‹С‚РёРё РјРµРЅСЋ
			beforeNavOpen: function () {},
			// РЎСЂР°Р±Р°С‚С‹РІР°РµС‚ РїСЂРё Р·Р°РєСЂС‹С‚РёРё РјРµРЅСЋ
			beforeNavClose: function () {}

		};

	function Plugin(obj, options) {
		this.settings = $.extend({}, defaults, options);
		this._defaults = defaults;
		this.init();
	}

	$.extend(Plugin.prototype, {

		init: function () {

			$(this.settings.navContainer).append($(this.settings.navBlock).clone());
			var self = this,
				$nav = this.$nav = $(this.settings.navWrapper),
				$menuButon = this.$menuButon = $('<span class="hamburger"><span class="icon-hamburger"></span></span>');

			this._bodyOverflow = $('body').css('overflow');

			// Hack to prevent mobile safari scrolling the whole body when nav is open
			// @todo: РїСЂРѕРІРµСЂРёС‚СЊ РЅР° СЂР°Р·Р»РёС‡РЅС‹С… СѓСЃС‚СЂРѕР№СЃС‚РІР°С…
			if (navigator.userAgent.match(/(iPad|iPhone|iPod)/g)) {
				$nav.children().addClass('ios-fix');
			}

			$('body').append($menuButon);

			$().add($menuButon).add($nav.find('.hamburger')).on('click', function () {
				self.toggleNav();
			});
			this.settings.onInit.call($menuButon, $nav);

		},

		toggleNav: function () {

			var self = this;

			this.$nav.fadeToggle(400);

			self.toggleBodyOverflow();

			$().add(this.$menuButon).add(this.$nav).toggleClass('active');

			this.settings.onNavToggle.call(this.$menuButon, this.$nav);
		},

		toggleBodyOverflow: function () {

			var self = this;

			$body.toggleClass('no-scroll');
			var isNavOpen = $body.hasClass('no-scroll');

			$body
				.css({
					'overflow': isNavOpen ? 'hidden' : self._bodyOverflow,
					'width': isNavOpen ? $window.width() : ''
				});

			if (isNavOpen) {
				this.settings.beforeNavOpen.call(this.$menuButon, this.$nav);

				$(window).on('resize.' + pluginName + ' orientationchange.' + pluginName, function (event) {
					self.navResize(event);
				});
			}
			else {
				this.settings.beforeNavClose.call(this.$menuButon, this.$nav);

				$(window).off('resize.' + pluginName + ' orientationchange.' + pluginName);
			}

		},
		navResize: function (event) {
			if (event && (event.type === 'resize' || event.type === 'orientationchange')) {
				var windowWidth = $window.width();
				if (windowWidth === previousResizeWidth) {
					return;
				}
				$body.css('width', windowWidth);
				previousResizeWidth = windowWidth;
			}
		}

	});

	if (typeof $[pluginName] === 'undefined') {

		$[pluginName] = function (options) {
			return new Plugin(this, options);
		};

	}

}(jQuery, window, document));