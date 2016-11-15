$GeoMapp = {
	container: null,
	data: {},
	cats: {},
	sets: {},
	items: {},
	panel: {},
	activeItems: {},
	icon: {},
	points: {},
	markers: {},
	lines: {},
	routes: {},
	activeMarkers: {},
	activeLine: {},
	activeLines: {},

	createRules: function (selectors, rules, index) {
		if (!index && index != 0) {
			index = this.link.cssRules.length;
		}
		if (this.link.insertRule) {
			this.link.insertRule(selectors + '{' + rules + '}', index);
		} else {
			this.link.addRule(selectors, rules, index);
		}
	},

	clone: function (curObject, params) {
		var newObject = new curObject.constructor();

		for (var i in curObject) {
			if (curObject.hasOwnProperty(i)) {
				newObject[i] = curObject[i];
			}
		}

		for (var i in params) {
			newObject[i] = params[i];
		}

		return newObject;
	},

	init: function (options) {
		var _class = this;	

		if ('ontouchstart' in window || 'onmsgesturechange' in window) {
			this.touch = true;
			$(document.documentElement).addClass('touchscreen');
		}

		$(function () {
			_class.options = options;
			_class.container = $('.map-container');
			_class.input = $('[data-action="select"]');
			_class.form = _class.input.closest('form');

			if (_class.data.cluster) {
				_class.clusterOptions = {
					averageCenter: true
				};

				if (_class.data.cluster.grid) {
					_class.clusterOptions.gridSize = _class.data.cluster.grid;
				}

				if (_class.data.cluster.sizes) {
					_class.clusterOptions.styles = [];

					for (var i = 0, size, j; size = _class.data.cluster.sizes[i]; i++) {
						j = {
							url: _class.data.cluster.icon,
							width: _class.data.cluster.sizes[i],
							height: _class.data.cluster.sizes[i]
						};

						if (_class.data.cluster.color) {
							j.textColor = _class.data.cluster.color;
						}

						if (i > 0) {
							j.backgroundPosition = '-' + _class.data.cluster.sizes[i - 1] + 'px 0';
						}

						_class.clusterOptions.styles.push(j);
					}
				}
			}

			if (options.height) {
				_class.container.height(options.height);
			}

			if (_class.data.cats) {
				var _list = $($('<ul class="map-category-list">')),
					H = _class.data.icon.height;

				$('<style>').attr('type', 'text/css').appendTo($(document.documentElement));
				_class.link = document.styleSheets[document.styleSheets.length - 1];
				if (!_class.link.cssRules) {
					_class.link.cssRules = _class.link.rules;
				}

				_class.createRules('.map-category-item:before', 'background-image:url(' + _class.data.icon.address + ');');
				_class.markerBounds = new google.maps.LatLngBounds();

				if (_class.data.objects) {
					_class.entities = _class.data.objects;
				} else if (_class.data.events) {
					H = 15;
					_class.container.addClass('map-popup-short');
					_class.entities = _class.data.events;
				} else if (_class.data.routes) {
					_class.icon.start = {
						url: _class.data.icon.address,
						size: new google.maps.Size(_class.data.icon.width, _class.data.icon.height),
						anchor: new google.maps.Point(_class.data.icon.width / 2, H),
						origin: new google.maps.Point(0, 30)
					};
					_class.icon.end = _class.clone(_class.icon.start, {
						origin: new google.maps.Point(_class.data.icon.width, 30)
					});
					_class.icon.inner = _class.clone(_class.icon.start, {
						size: new google.maps.Size(_class.data.icon.width, 30),
						anchor: new google.maps.Point(_class.data.icon.width / 2, 15),
						origin: new google.maps.Point(_class.data.icon.width * 2, 30)
					});
					_class.icon.def = _class.clone(_class.icon.inner, {
						origin: new google.maps.Point(_class.data.icon.width * 3, 30)
					});
					_class.icon.hover = _class.clone(_class.icon.inner, {
						origin: new google.maps.Point(_class.data.icon.width * 4, 30)
					});
					_class.pathOptions = {
						strokeColor: _class.data.path.color,
						strokeOpacity: _class.data.path.opacity,
						strokeWeight: _class.data.path.width
					};
					_class.entities = _class.data.routes;
				}

				for (var i in _class.data.cats) {
					var rule = '',
						count = 0;

					if (!_class.data.routes) {
						_class.icon[i] = {
							url: _class.data.icon.address,
							size: new google.maps.Size(_class.data.icon.width, _class.data.icon.height),
							anchor: new google.maps.Point(_class.data.icon.width / 2, H),
							origin: new google.maps.Point((_class.data.cats[i].pos || 0), 30)
						};
					}

					if (_class.data.cats[i].icon) {
						rule += 'background-image:url(' + _class.data.cats[i].icon + ');';
						_class.icon[i].url = _class.data.cats[i].icon;
					}
					if (_class.data.cats[i].pos) {
						rule += 'background-position:-' + _class.data.cats[i].pos + 'px 0;';
					}
					if (rule) {
						_class.createRules('.' + i + '.map-category-item:before,.' + i + ' .map-category-item:before', rule);
					}

					_class.sets[i] = $('<ul class="map-category-list ' + i + ' none" data-id="' + i + '" data-set="list"></ul>');

					if (_class.data.objects) {
						count = createMarkers(_class.entities[i], i, _class.sets[i]);
					} else if (_class.data.events) {
						count = createMarkers(_class.entities[i], i, _class.sets[i]);
					} else if (_class.data.routes) {
						count = createRoutes(_class.entities[i], i, _class.sets[i]);
					}

					_class.cats[i] = $('<li class="map-category-item ' + i + '" data-id="' + i + '" data-action="list" data-count="' + count + '">').append('<span class="map-category-name"><span>' + _class.data.cats[i].name + '</span></span> <span class="map-category-count">(' + count + ')</span>').appendTo(_list);
				}
			}

			function setContent(data, item) {
				var content = '<div class="map-category-item-wrapper"><div class="map-item-geo" data-action="geo" title="Show on map"></div>';

				if (data.date) {
					content += '<div class="map-item-date">' + data.date + '</div>';
				}
				content += '<dl class="map-item-info">';
				if (data.name) {
					content += '<dt class="map-item-name">';
					if (data.url) {
						content += '<a href="' + data.url + '">' + data.name + '</a>';
					} else {
						content += data.name;
					}
					content += '</dt>';
				}
				content += '<dd class="map-item-detail">';
				if (data.address) {
					content += '<div class="map-item-address">' + data.address + '</div>';
				}
				if (data.description) {
					content += '<div class="map-item-description">' + data.description + '</div>';
				}
				if (data.opening) {
					content += '<div class="map-item-opening">' + data.opening + '</div>';
				}
				content += '</dd></dl>';

				if (data.phone || data.link) {
					if (data.phone) {
						content += '<div class="map-item-contacts">';
						var phone = data.phone.split(/\s*,\s*/);

						content += '<ul>';
						for (var j in phone) {
							content += '<li>' + phone[j] + '</li>';
						}
						content += '</ul>';
					} else {
						content += '<div class="map-item-contacts single">';
					}
					if (data.link) {
						content += '<a href="' + data.link + '">' + data.link + '</a>';
					}
					content += '</div></div>';
				}

				item.append(content);

				return content;
			}

			function createRoutes(data, id, _list) {
				var count = 0,
					current;

				_class.items[id] = {};

				for (var i in data) {
					current = i;

					_class.items[id][i] = [data[i].name, createSubItems(data[i], _list, i, id)];
					_class.pathOptions.path = _class.routes[i].coords;
					_class.lines[i] = new google.maps.Polyline(_class.pathOptions);
					_class.lines[i].customId = i;

					google.maps.event.addListener(_class.lines[i], 'click', function () {
						_class.activeRoute(this);
					});
					google.maps.event.addListener(_class.lines[i], 'mouseover', function () {
						_class.overRoute(this);
					});
					google.maps.event.addListener(_class.lines[i], 'mouseout', function () {
						_class.outRoute(this);
					});
				}

				function createSubItems(data, parent, id, catid, child) {
					if (!child) {
						_class.routes[id] = {
							markers: [],
							start: null,
							end: null,
							coords: []
						};
						count++;
					} else {
						id = catid + '_' + id;
					}

					var item = $('<li class="map-category-item" data-item="list" data-id="' + id + '" data-lat="' + data.lat + '" data-lng="' + data.lng + '">').appendTo(parent),
						content = setContent(data, item),
						point = new google.maps.LatLng(
							data.lat,
							data.lng
						);

					if (!child) {
						_class.markers[id] =  new google.maps.Marker({
							icon: _class.icon.def,
							position: point,
							title: String(data.name)
						});
						_class.routes[id].start = id;
						_class.routes[id].coords.push(point);
						_class.markerBounds.extend(point);
					} else {
						if (child == 'end') {
							_class.markers[id] =  new google.maps.Marker({
								icon: _class.icon.def,
								position: point,
								title: data.description
							});
							_class.routes[catid].end = id;
						} else {
							_class.markers[id] =  new google.maps.Marker({
								icon: _class.icon.inner,
								position: point,
								title: data.description
							});
							_class.routes[catid].markers.push(id);
						}
					}
					_class.markers[id].customId = current;

					if (!child || child == 'end') {
						google.maps.event.addListener(_class.markers[id], 'mouseover', function () {
							_class.overRoute(_class.lines[this.customId]);
						});
						google.maps.event.addListener(_class.markers[id], 'mouseout', function () {
							_class.outRoute(_class.lines[this.customId]);
						});
					}
					google.maps.event.addListener(_class.markers[id], 'click', function() {
						_class.infoPlace.setContent(content, data.photo);
						_class.infoPlace.open(_class.map, this);
						$(document).trigger('popup:closed', [item]);
						_class.container.toggleClass('map-popup-short', child == 'inner');
						_class.activeRoute(_class.lines[this.customId], this);
					});

					if (data.subitems) {
						var subcat =  $('<ul class="map-subcategory-list">').appendTo(item);

						for (var i = 0, point; i < data.subitems.length; i++) {
							point = new google.maps.LatLng(
								data.subitems[i].lat,
								data.subitems[i].lng
							);

							_class.routes[id].coords.push(point);
							_class.markerBounds.extend(point);
							if (i == data.subitems.length - 1) {
								if (!data.closed) {
									createSubItems(data.subitems[i], subcat, i, id, 'end');
								} else {
									_class.routes[id].coords.push(_class.routes[id].coords[0]);
								}
							} else if (data.subitems[i].description) {
								createSubItems(data.subitems[i], subcat, i, id, 'inner');
							}
						}
					}
					return item;
				}
				return count;
			}

			function createMarkers(data, id, _list) {
				var count = 0;

				_class.items[id] = {};
				for (var i in data) {
					_class.items[id][i] = [data[i].name, createSubItems(data[i], _list, i, id)];
				}

				function createSubItems(data, parent, id, catid) {
					var item = $('<li class="map-category-item" data-item="list" data-id="' + id + '" data-lat="' + data.lat + '" data-lng="' + data.lng + '">').appendTo(parent),
						content = setContent(data, item),
						point = new google.maps.LatLng(
							data.lat,
							data.lng
						);

					count++;

					_class.markers[id] = new google.maps.Marker({
						icon: _class.icon[catid],
						position: point,
						title: String(data.name)
					});
					_class.markerBounds.extend(point);

					google.maps.event.addListener(_class.markers[id], 'click', function() {
						_class.infoPlace.setContent(content, data.photo);
						_class.infoPlace.open(_class.map, this);
						$(document).trigger('popup:closed', [item]);
					});

					if (data.subitems) {
						var subcat =  $('<ul class="map-subcategory-list">').appendTo(item);
						for (var i in data.subitems) {
							_class.items[catid][i] = [data.subitems[i].name, createSubItems(data.subitems[i], subcat, i, catid), id];
						}
					}
					return item;
				}
				return count;
			}

			_class.scrolls = $('[data\-container~="scroll"]').each(function () {
				var _self = $(this),
					_container = _self.closest('[data\-container~="collapse"]');

				_self
					.data('scroller', _self.find('[data\-target~="scroll"]'))
					.data('info', _self.data('scroller').find('[data\-info~="scroll"]'));

				if (_container.hasClass('map-filter')) {
					_class.panel.left = _container;
					_self.data('info').append(_list);
				} else if (_container.hasClass('map-list')) {
					_class.panel.right = _container;
					for (var i in _class.sets) {
						_self.data('info').append(_class.sets[i]);
					}
				}

				if (options.replaceRules) {
					if (!_class.touch) {
						_self
							.data('rule', $('<div class="map-rule"></div>').appendTo(_self))
							.data('float', $('<div class="map-rule-float" data-action="scroll"></div>').appendTo(_self.data('rule')))
							.data('boxHeight', parseInt(_self.data('float').css('min-height')));
					}
					_self.trigger('set:rule');
				}
			});

			if (options.replaceRules) {
				$(window).bind('resize', function () {
					_class.scrolls.filter('[data\-container~="variable"]').trigger('set:rule');
				});
			}

			_class.map = new google.maps.Map(_class.container.find('.map-canvas').get(0), {
				//zoom: 11,
				minZoom: 2,
				//center: new google.maps.LatLng(54.96657837889866, 73.37287902832031),
				mapTypeId: google.maps.MapTypeId.ROADMAP,
				mapTypeControl: false,
				scaleControl: true,
				zoomControlOptions: {
					position: google.maps.ControlPosition.RIGHT_BOTTOM
				},
				panControlOptions: {
					position: google.maps.ControlPosition.RIGHT_BOTTOM
				}
			});

			_class.infoPlace = new InfoPlaceWindow({});
			_class.map.fitBounds(_class.markerBounds);
			_class.map.panToBounds(_class.markerBounds);

			_class.input
			.bind('input propertychange', function (e) {
				setTimeout(function () {
					_class.form.trigger('check:value', [_class.input.val()]);
				}, 0);
			})
			.bind('keydown', function (e) {
/*@cc_on
	@if (@_jscript_version < 10)
				if (e.keyCode == 8 || e.keyCode == 46) {
					setTimeout(function () {
						_class.form.trigger('check:value', [_class.input.val()]);
					}, 0);
				}
	@end
@*/
				if (e.keyCode == 27) {
					setTimeout(function () {
						_class.input.val('');
						_class.form.trigger('check:value');
						_class.showMarkers(_class.panel.left.find('[data\-action~="list"].active'));
					}, 0);
				}
			});
		});

		$(document)
		.on('submit', '[data\-container~="refresh"]', function (e) {
			var _self = $(this),
				_refresh = _self.find('[data\-action~="refresh"]');

			e.preventDefault();

			if (_refresh.hasClass('active')) {
				_class.input.get(0).defaultValue = _class.input.val();
				_class.updateMarkers();
				setTimeout(function () {
					_refresh.removeClass('active');
				}, 0);
			}
		})
		.on('mousedown touchstart', '[data\-container~="refresh"] [data-action="clear"]', function (e) {
			setTimeout(function () {
				_class.input.val('').trigger('focus');
				_class.form.trigger('check:value');
				_class.showMarkers(_class.panel.left.find('[data\-action~="list"].active'));
			}, 0);
		})
		.on('check:value', function (e, value) {
			var _refresh = _class.form.find('[data\-action~="refresh"]'),
				_clear = _class.form.find('[data\-action~="clear"]');

			value = value || '';
			_class.activeItems = {};

			switch (value.length) {
				default:
					var r = new RegExp(value, 'i'),
						globalCount = 0;

					//_input.get(0).defaultValue != value
					for (var i in _class.cats) {
						var count = 0,
							flag = _class.cats[i].hasClass('active'),
							sub = {};

						for (var j in _class.items[i]) {
							if (_class.entities[i][j] && _class.entities[i][j].subitems) {
								_class.items[i][j][1].removeClass('include');
							}

							if (r.test(_class.items[i][j][0])) {
								_class.items[i][j][1].removeClass('none');
								count++;

								if (flag) {
									globalCount++;
								}

								if (!_class.activeItems[i]) {
									_class.activeItems[i] = {};
								}
								_class.activeItems[i][j] = _class.items[i][j];

								if (_class.items[i][j][2]) {
									sub[_class.items[i][j][2]] = true;
								}
							} else {
								_class.items[i][j][1].addClass('none');
							}
						}

						for (var k in sub) {
							_class.items[i][k][1].addClass('include');
						}

						if (count) {
							_class.cats[i].removeClass('none');
						} else {
							_class.cats[i].addClass('none');
						}

						_class.cats[i].find('.map-category-count').html('(' + count + ')');
					}

					if (globalCount) {
						_refresh.addClass('active');
					} else {
						_refresh.removeClass('active');
					}

					_clear.addClass('active');
					break;
				case 0:
					_clear.removeClass('active');
					_refresh.removeClass('active');
					set();
					break;
				case 1:
					_clear.addClass('active');
					_refresh.removeClass('active');
					set();
			}

			function set() {
				for (var i in _class.sets) {
					for (var j in _class.items[i]) {
						_class.items[i][j][1].removeClass('none');
					}
					_class.cats[i].removeClass('none').find('.map-category-count').html('(' + _class.cats[i].data('count') + ')');
				}
			}

			_class.scrolls.trigger('set:rule');
		})
		.on('click', '[data\-action~="collapse"]', function (e) {
			var _self = $(this),
				_container = _self.closest('[data\-container~="collapse"]'),
				options = {};

			options[_container.is(_class.panel.left) ? 'left' : 'right'] = _self.data('type') == 'show' ? 'show' : 'collapse';
			_class.setPanels(options);
		})
		.on('click', '[data\-action~="list"]', function (e) {
			var _self = $(this);

			_class.setActive(_self);
		})
		.on('click', '[data\-container~="clear"] [data\-action~="clear"]', function (e) {
			var _self = $(this),
				_container = _self.closest('[data\-container~="list"]');

			_class.setActive(_container.find('[data\-action~="list"].active'));
		})
		.on('click', '[data\-action~="geo"]', function (e) {
			var _self = $(this),
				_item = _self.closest('[data-item]'),
				id = _item.data('id');

			$(document).trigger('popup:closed', [_item]);
			_class.setPanels({
				right: 'collapse'
			});

			google.maps.event.trigger(_class.markers[id], 'click');
		})
		.on('popup:closed', function (e, _item) {
			if (_class.active) {
				_class.active.removeClass('active');
			}
			if (_item) {
				_class.active =_item;
				_class.active.addClass('active');
			} else {
				delete _class.active;
			}
		})
		.on('mousedown', '[data\-action~="scroll"]', function (e) {
			var _self = $(e.target).closest('[data\-container~="scroll"]'),
				scroller = _self.data('scroller'),
				box = _self.data('float'),
				rule = _self.data('rule'),
				H = scroller.height(),
				h = rule.height(),
				D = _self.data('info').height(),
				coords = {
					H: box.height(),
					T: box.position().top,
					Y: e.clientY
				};

			function _up (e) {
				$(document).unbind('mouseup', _up).unbind('mousemove', _move);
			}

			function _move (e) {
				e.preventDefault();
				e.stopPropagation();
				try {
					getSelection().removeAllRanges();
				} catch (z) {}
				coords.delta = e.clientY - coords.Y;
				_self.data('coords', coords).trigger('set:scroll');
			}

			$(document).on('mouseup', _up).on('mousemove', _move);
		})
		.on('mousedown', '.map-rule', function (e) {
			var _self = $(e.target),
				_container = _self.closest('[data\-container~="scroll"]'),
				box = _container.data('float');

			if (!_self.is(box)) {
				var t = box.position().top,
					p = e.clientY - e.target.getBoundingClientRect().top - t;

				_container.data('coords').T = t;
				_container.data('coords').delta = _container.data('coords').H * p / Math.abs(p);
				_container.trigger('set:scroll', [true]);
			}
		})
		.on('set:rule', function (e) {
			var _self = $(e.target);

			if (_class.touch) {
				if (!_self.data('iscroll')) {
					_self.data('iscroll', new iScroll(e.target, {
						snap: true,
						momentum: false,
						hScroll: false,
						hideScrollbar: false,
						//scrollbarClass: 'map-rule',
						onScrollEnd: function () {
							
						}
					}));
				} else {
					_self.data('iscroll').refresh();
				}
			} else {
				var scroller = _self.data('scroller'),
					H = scroller.height();

				if (H) {
					var box = _self.data('float'),
						h = _self.data('rule').height(),
						D = _self.data('info').height();

					if (H / D < 1) {
						var d = Math.max(Math.round(h * H / D), _self.data('boxHeight'));

						_self.addClass('scrolling').data('coords', {
							H: d
						});
						box.animate({
							height: _self.data('coords').H + 'px',
							top: Math.round((h - d) * scroller.scrollTop() / (D - H)) + 'px'
						}, 400);
						scroller.bind('scroll', function (e) {
							box.css({
								top: Math.round((h - d) * scroller.scrollTop() / (D - H)) + 'px'
							})
						});
					} else {
						_self.removeClass('scrolling');
					}
				}
			}
		})
		.on('set:scroll', function (e, animation) {
			var _self = $(e.target);

			var scroller = _self.data('scroller'),
				box = _self.data('float'),
				rule = _self.data('rule'),
				H = scroller.height(),
				h = rule.height(),
				D = _self.data('info').height(),
				coords = _self.data('coords');

			var t = coords.T + coords.delta,
				T = Math.round(t * D / H);

			if (t > h - coords.H) {
				t = h - coords.H;
				T = D - H;
			} else if (t < 0) {
				t = T = 0;
			}
			if (animation) {
				rule.addClass('active');
				box.animate({
					top: t + 'px'
				}, 400, function () {
					rule.removeClass('active');
				});
				scroller.animate({
					scrollTop: T
				}, 400, function () {
					
				});
			} else {
				box.css({
					top: t + 'px'
				});
				scroller.scrollTop(T);
			}
		});
	},

	setActive: function (elems) {
		var _class = this;

		if (elems.length) {
			var _container = elems.eq(0).closest('[data\-container~="list"]'),
				_target = _container.find('[data\-target~="list"]'),
				count = _container.data('count') || 0,
				_scroll = _class.panel.left.find('[data\-container~="scroll"]'),
				_buttonblock = _class.panel.left.find('[data\-container~="clear"]');

			elems.each(function () {
				var _self = $(this),
					id = _self.data('id'),
					_list = _target.find('[data\-set~="list"][data\-id~="' + id + '"]');

				if (_self.hasClass('active')) {
					_self.removeClass('active');
					_list.addClass('none');
					count--;
				} else {
					_self.addClass('active');
					_list.removeClass('none');
					count++;
				}
				_class.showMarkers(_self);
			});

			if (count == 0) {
				this.setPanels({
					right: 'invisible'
				});
				_scroll.removeData('few');
				_scroll.animate({
					bottom: 0 + 'px'
				}, 400, function () {
					if (_class.options.replaceRules) {
						$(this).trigger('set:rule');
					}
				});
				_buttonblock.animate({
					height: 0 + 'px'
				}, 400, function () {
					
				});
			} else {
				if (!_class.panel.right.hasClass('show')) {
					this.setPanels({
						right: 'collapse'
					});
				} else {
					_target.closest('[data\-container~="scroll"]').trigger('set:rule');
				}
				if (count > 1 && !_scroll.data('few')) {
					var _first = elems.siblings(':first'),
						_second = _first.next();

					if (_second.length){
						_scroll.data('few', true);
						_scroll.animate({
							bottom: Math.round(Math.abs(_second.position().top - _first.position().top)) + 'px'
						}, 400, function () {
							if (_class.options.replaceRules) {
								$(this).trigger('set:rule');
							}
						});
					}
					_buttonblock.animate({
						height: _buttonblock.find('[data\-action~="clear"]').css('height')
					}, 400, function () {
						
					});
				}
			}
			_container.data('count', count);
		}
	},

	markerCluster: function () {
		if (this.cluster) {
			this.cluster.removeMarkers(this.markersdata);
		}
		
		this.markersdata = [];
		for (var i in this.activeMarkers) {
			this.markersdata.push(this.markers[i]);
		}
		this.cluster = new MarkerClusterer(this.map, this.markersdata, this.clusterOptions);
	},

	updateMarkers: function () {
		var _class = this;

		if (_class.data.routes) {
			_class.activeLines = {};

			for (var i in _class.lines) {
				_class.deleteRoute(i);
			}

			for (var id in _class.activeItems) {
				if (_class.cats[id].hasClass('active')) {
					for (var i in  _class.activeItems[id]) {
						_class.showRoute(i);
						_class.activeLines[i] = _class.lines[i];
						if (_class.lines[i] == _class.activeLine.route) {
							_class.activeRoute(_class.lines[i], true);
						}
					}
				}
			}
		} else {
			_class.activeMarkers = {};

			for (var i in  _class.markers) {
				_class.markers[i].setMap(null);
			}

			for (var id in _class.activeItems) {
				if (_class.cats[id].hasClass('active')) {
					for (var i in  _class.activeItems[id]) {
						_class.markers[i].setMap(_class.map);
						_class.activeMarkers[i] = _class.markers[i];
					}
				}
			}
			_class.markerCluster();
		}

		if (_class.active) {
			_class.infoPlace.close();
			$(document).trigger('popup:closed');
		}
	},

	activeRoute: function (_self, flag) {
		var _class = this;

		if (_class.activeLine.route) {
			if (_class.activeLine.route == _self && !flag) {
				_class.unactiveRoute(_class.activeLine.route);
				_class.activeLine.route = null;
			} else {
				_class.unactiveRoute(_class.activeLine.route);
				_class.activeLine.route = _self;
			}
		} else {
			_class.activeLine.route = _self;
		}
		if (_class.activeLine.route) {
			_class.activeLine.route.setOptions({
				strokeColor: _class.data.path.colorActive,
				zIndex: 1
			});
			_class.markers[_class.routes[_self.customId].start].setIcon(_class.icon.start);
			if (_class.routes[_self.customId].end) {
				_class.markers[_class.routes[_self.customId].end].setIcon(_class.icon.end);
			}
			for (var i in _class.routes[_self.customId].markers) {
				_class.markers[_class.routes[_self.customId].markers[i]].setVisible(true);
			}
		}

		_class.infoPlace.close();
		$(document).trigger('popup:closed');
	},

	unactiveRoute: function (_self) {
		var _class = this;

		_class.activeLine.route.setOptions({
			strokeColor: _class.data.path.color,
			zIndex: 0
		});

		_class.markers[_class.routes[_self.customId].start].setIcon(_class.icon.def);
		if (_class.routes[_self.customId].end) {
			_class.markers[_class.routes[_self.customId].end].setIcon(_class.icon.def);
		}
		for (var i in _class.routes[_self.customId].markers) {
			_class.markers[_class.routes[_self.customId].markers[i]].setVisible(false);
		}
	},

	overRoute: function (_self) {
		var _class = this;

		if (_self != _class.activeLine.route) {
			_self.setOptions({
				strokeOpacity: _class.data.path.opacityHover
			});
			_class.markers[_class.routes[_self.customId].start].setIcon(_class.icon.hover);
			if (_class.routes[_self.customId].end) {
				_class.markers[_class.routes[_self.customId].end].setIcon(_class.icon.hover);
			}
		}
	},

	outRoute: function (_self) {
		var _class = this;

		if (_self != _class.activeLine.route) {
			_self.setOptions({
				strokeOpacity: _class.data.path.opacity
			});
			_class.markers[_class.routes[_self.customId].start].setIcon(_class.icon.def);
			if (_class.routes[_self.customId].end) {
				_class.markers[_class.routes[_self.customId].end].setIcon(_class.icon.def);
			}
		}
	},

	deleteRoute: function (i) {
		var _class = this;

		_class.lines[i].setMap(null);
		_class.markers[_class.routes[i].start].setMap(null);

		if (_class.routes[i].end) {
			_class.markers[_class.routes[i].end].setMap(null);
		}
		for (var j in _class.routes[i].markers) {
			_class.markers[_class.routes[i].markers[j]].setMap(null);
		}
	},

	showRoute: function (i) {
		var _class = this;

		_class.lines[i].setOptions({
			strokeColor: _class.data.path.color,
			zIndex: 0
		});
		_class.lines[i].setMap(_class.map);

		_class.markers[_class.routes[i].start].setIcon(_class.icon.def);
		_class.markers[_class.routes[i].start].setMap(_class.map);

		if (_class.routes[i].end) {
			_class.markers[_class.routes[i].end].setIcon(_class.icon.def);
			_class.markers[_class.routes[i].end].setMap(_class.map);
		}

		for (var j in _class.routes[i].markers) {
			_class.markers[_class.routes[i].markers[j]].setVisible(false);
			_class.markers[_class.routes[i].markers[j]].setMap(_class.map);
		}
	},

	showMarkers: function (elems) {
		var _class = this;

		elems.each(function () {
			var _self = $(this),
				id = _self.data('id'),
				_items = _class.items[id];

			if (_self.hasClass('active')) {
				if (_class.activeItems[id]) {
					_items = _class.activeItems[id];
				}

				if (_class.data.routes) {
					for (var i in _items) {
						if (!_class.activeLines[i]) {
							_class.activeLines[i] = _class.lines[i];
							_class.showRoute(i);
						}
					}
				} else {
					for (var i in _items) {
						if (!_class.activeMarkers[i]) {
							_class.activeMarkers[i] = _class.markers[i];
							_class.markers[i].setMap(_class.map);
						}
					}
					_class.markerCluster();
				}
			} else {
				if (_class.data.routes) {
					var active_id = _class.active ? _class.active.data('id') : null;

					for (var i in _items) {
						if (_class.lines[i]) {
							_class.deleteRoute(i);
							delete _class.activeLines[i];

							if (_items[i][1].is(_class.active)) {
								_class.infoPlace.close();
								$(document).trigger('popup:closed');
							}
						}
					}
				} else {
					for (var i in _items) {
						if (_class.markers[i]) {
							_class.markers[i].setMap(null);
							delete _class.activeMarkers[i];

							if (_items[i][1].is(_class.active)) {
								_class.infoPlace.close();
								$(document).trigger('popup:closed');
							}
						}
					}
					_class.markerCluster();
				}
			}
		});
	},

	setPanels: function (options) {
		var _scroll = {
				left: this.panel.left.find('[data\-container~="scroll"]'),
				right: this.panel.right.find('[data\-container~="scroll"]')
			};

		if (!options) {
			options = {
				left: 'show',
				right: ''
			}
		}

		if (options.left == 'lock' || options.right == 'show') {
			//Левая развернута и закреплена, правая развернута
			this.panel.left.removeClass('collapse').addClass('lock');
			this.panel.right.removeClass('collapse').addClass('show');
			if (this.options.replaceRules) {
				_scroll.left.trigger('set:rule');
				_scroll.right.trigger('set:rule');
			}
		} else {
			if (options.left) {
				this.panel.right.addClass('collapse');
				if (options.left == 'collapse') {
					//Левая свернута
					this.panel.left.removeClass('lock').addClass('collapse');
				} else if (options.left == 'show') {
					//Левая развернута
					this.panel.left.removeClass('collapse lock');
					if (this.options.replaceRules) {
						_scroll.left.trigger('set:rule');
					}
				}
			}
			if (options.right) {
				this.panel.left.removeClass('lock');
				if (options.right == 'collapse') {
					//Правая свернута
					this.panel.right.addClass('show collapse');
				} else if (options.right == 'invisible') {
					//Правая невидима
					this.panel.right.removeClass('show').addClass('collapse');
				}
			}
		}

		return this;
	}
};

function InfoPlaceWindow(options) {
	this.extend(InfoPlaceWindow, google.maps.OverlayView);
	this.isOpen_ = false;

	options = options || {};
	this.buildDom_(options);
	this.setValues(options);
}

InfoPlaceWindow.prototype.extend = function(a, b) {
	return (function(object) {
		for (var property in object.prototype) {
			this.prototype[property] = object.prototype[property];
		}
		return this;
	}).apply(a, [b]);
};

InfoPlaceWindow.prototype.onAdd = function() {
	var panes = this.getPanes();
	if (panes) {
		this.container_.appendTo(panes.floatPane);
	}
};

InfoPlaceWindow.prototype.reset = function() {
	this.container_.reset();
};

InfoPlaceWindow.prototype.draw = function() {
	var projection = this.getProjection();
	if (!projection) {
		return;
	}

	var latLng = this.get('position');
	if (!latLng) {
		this.close();
		return;
	}

	var pos = projection.fromLatLngToDivPixel(latLng);
	var width = this.container_.width();
	var height = this.container_.height();
	if (!width) {
		return;
	}

	this.container_.css({
		top: pos.y - height + 'px',
		left: pos.x - width / 2 + 'px'
	});
};

InfoPlaceWindow.prototype.buildDom_ = function(options) {
	var _class = this;

	this.container_ = $('<div class="map-popup"><span class="map-popup-close"></span><div class="map-popup-image"></div><div class="map-popup-container"><div></div></div></div>');
	this.image = this.container_.find('.map-popup-image');
	
	google.maps.event.addDomListener(this.container_.find('.map-popup-close').get(0), 'click', function() {
		_class.close();
		google.maps.event.trigger(_class, 'closeclick');
		$(document).trigger('popup:closed');
	});

	this.content_ = this.container_.find('.map-popup-container');
};

InfoPlaceWindow.prototype.onRemove = function() {
	if (this.container_.parent().length) {
		this.container_.remove();
	}
};

InfoPlaceWindow.prototype.isOpen = function() {
	return this.isOpen_;
};

InfoPlaceWindow.prototype.close = function() {
	this.container_.removeClass('active');
	this.isOpen_ = false;
};

InfoPlaceWindow.prototype.open = function(opt_map, opt_anchor) {
	var _class = this;

	setTimeout(function() {
		_class.updateContent_();

		if (opt_map) {
			_class.setMap(opt_map);
		}

		if (opt_anchor) {
			_class.set('anchor', opt_anchor);
			_class.bindTo('anchorPoint', opt_anchor);
			_class.bindTo('position', opt_anchor);
		}

		_class.redraw_();
		_class.isOpen_ = true;
		_class.container_.addClass('active');

		setTimeout(function() {
			_class.panToView();
		}, 200);
	}, 0);
};

InfoPlaceWindow.prototype.setPosition = function(position) {
	if (position) {
		this.set('position', position);
	}
};

InfoPlaceWindow.prototype.getPosition = function() {
	return this.get('position');
};

InfoPlaceWindow.prototype.position_changed = function() {
	this.draw();
};

InfoPlaceWindow.prototype.panToView = function() {
	var projection = this.getProjection();

	if (!projection || !this.container_.length) {
		return;
	}

	var map = this.get('map'),
		latLng = this.getPosition(),
		centerPos = projection.fromLatLngToContainerPixel(map.getCenter()),
		pos = projection.fromLatLngToContainerPixel(latLng),
		mapDiv = map.getDiv(),
		mapHeight = mapDiv.offsetHeight,
		height = this.container_.height(),
		spaceTop = centerPos.y - height,
		spaceBottom = mapHeight - centerPos.y,
		needsTop = spaceTop < 0,
		deltaY = 0;

	if (needsTop) {
		spaceTop *= -1;
		deltaY = (spaceTop + spaceBottom) / 2;
	}

	pos.y -= deltaY;
	latLng = projection.fromContainerPixelToLatLng(pos);

	if (map.getCenter() != latLng) {
		map.panTo(latLng);
	}
};

InfoPlaceWindow.prototype.setContent = function(content, image) {
	var _class = this;

	_class.set('content', content);
	_class.image.empty();

	if (image) {
		var _img = $('<img src="' + image + '">');

		if (!_img.get(0).height) {
			_img.bind('load', function () {
				_class.container_.css({
					top: parseInt(_class.container_.css('top')) - this.height + 'px'
				});
				$(this).appendTo(_class.image);
			});
		} else {
			_img.appendTo(_class.image);
		}
	}
};

InfoPlaceWindow.prototype.getContent = function() {
	return this.get('content');
};

InfoPlaceWindow.prototype.updateContent_ = function() {
	this.content_.html('').append(this.getContent());
	google.maps.event.trigger(this, 'domready');
	this.redraw_();
};

InfoPlaceWindow.prototype.redraw_ = function() {
	this.figureOutSize_();
	this.draw();
};

InfoPlaceWindow.prototype.figureOutSize_ = function() {
	var map = this.get('map');

	if (!map) {
		return;
	}

	var mapDiv = map.getDiv(),
		mapHeight = mapDiv.offsetHeight,
		height = this.get('minHeight') || 0,
		maxHeight = this.get('maxHeight') || 0;

	maxHeight = Math.min(mapHeight, maxHeight);

	var content = this.get('content');
	if (content) {
		var contentSize = this.getElementSize_(content, maxHeight);

		if (height < contentSize.height) {
			height = contentSize.height;
		}
	}

	if (maxHeight) {
		height = Math.min(height, maxHeight);
	}

	if (height > mapHeight) {
		height = mapHeight;
	}

	this.content_.height(height);
};

InfoPlaceWindow.prototype.getElementSize_ = function(element, opt_maxHeight) {
	var sizer = $('<div class="map-sizer map-popup">');

	if (typeof element == 'string') {
		sizer.html(element);
	} else {
		sizer.append(element.clone(true));
	}

	$(document.body).append(sizer);
	var size = new google.maps.Size(sizer.width(), sizer.height());

	sizer.remove();
	return size;
};