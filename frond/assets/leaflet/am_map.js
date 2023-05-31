/*!
 * A jQuery plugin to quickly create a leaflet map and add multiple interactive layers of points (using LatLong or UTM(x,y) coords).
 * Tested in Leaflet 1.5.1
 * Date: 2020-01-13
 */


(function ($) {

	$.fn.am_map = function (param1 = null, param2 = null) {

		if (am_map_methods[param1]) {

			return am_map_methods[param1].apply(this, Array.prototype.slice.call(arguments, 1));

		} else if (typeof param1 === 'object' || !param1) {						// Default to "init"

			return am_map_methods.init.apply(this, arguments);

		} else {

			$.error('** AM_MAP WARNING ** Method ' + param1 + ' does not exist on jQuery.tooltip');
			return this;

		}

	};


	// Plugin defaults – added as a property on our plugin function.

	$.fn.am_map.defaults = {
		center: [41.55, 2.45],
		height: '400px',
		background: 'terrain',
		iniZoom: 12
	};


	// Plugin methods

	var am_map_methods = {

		init: function (opts) {

			var map = this.data("map");

			if (!map) {

				if ($(this).length > 0) {

					// Extend our default options with those provided.
					var options = $.extend({}, $.fn.am_map.defaults, opts);

					this.data("options", options);

					// Create map

					var divMap = $(this)[0].id;

					$(this).height(options.height);

					if (options.background == 'osm') {
						var bgLayer = new L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png');
					} else {
						var bgLayer = new L.StamenTileLayer(options.background);
					}

					var map = new L.Map(divMap, {
						center: new L.LatLng(options.center[0], options.center[1]),
						zoom: options.iniZoom,
						layers: [bgLayer],
					});

					this.data("map", map);
					this.data("layers", []);

				} else {

					console.log('** AM_MAP WARNING ** There isn\'t any ' + $(this).selector + ' element in the document.');

				}

			}

			return this;

		},

		addLayer: function (params) {

			if (!this.data("map")) {
				am_map_methods.init.apply(this);
			}

			var map = this.data("map");
			var options = this.data("options");

			var layers = this.data("layers");
			var layer_name = (params.name) ? params.name : 'am_map_layer';

			if (layers.indexOf(layer_name) === -1) {
				layers.push(layer_name);
			}

			var southH = (params.UTMsouth) ? params.UTMsouth : false;

			var pts = (Array.isArray(params.points[0])) ? params.points : [params.points];
			var code = [];
			var name = [];

			// Remove layer if exists

			if (this.data(layer_name)) {
				map.removeLayer(this.data(layer_name));
			}

			var arrMarkers = new Array();
			var center;

			pts.forEach(function (pt, idx) {

				// Convert UTM coords to LatLong if needed

				if (params.UTMzone) {
					var item = L.utm({ x: pt[0], y: pt[1], zone: params.UTMzone, southHemi: southH });
					var point = item.latLng();
				} else {
					var point = [pt[0], pt[1]];
				}

				var marker_opts = {};
				if (pt[2]) {
					marker_opts = pt[2];
				}

				if (params.icon) {
					marker_opts.icon = L.divIcon({ className: 'custom-div-icon', html: params.icon });
				}

				arrMarkers.push(L.marker(point, marker_opts));

				center = point;

			});

			var markers = new L.featureGroup(arrMarkers);

			// Click and PopUp events

			markers.on('click', function (e) {

				var elementObj = this._layers[e.layer._leaflet_id];

				var lat = elementObj._latlng.lat.toFixed(4);
				var lng = elementObj._latlng.lng.toFixed(4);
				var name = (elementObj.options.name) ? elementObj.options.name : '';

				if (elementObj.options.code && params.url) {
					name = '<a href="' + params.url + elementObj.options.code + '"><i class="fa fa-link" aria-hidden="true"></i> ' + name + '</a>';
				}

				var desc = (elementObj.options.desc) ? elementObj.options.desc : '';

				var ruta = `https://www.google.com/maps/search/?api=1&query=${lat},${lng}`;

				var content = `<h4>${name}</h4><hr>`
					+ '<form class="form-inline">'
					+ '  <label>Lat , Lng   </label></td>'
					+ `  <input type="text" class="form-control" value="${lat},${lng}" size="15"></td>`
					+ '</form>'
					+ '<hr>'
					+ '<table width="100%">'
					+ '  <tr>'
					+ '    <td>'
					+ `        <a href="${ruta}" class="btn btn-info" target="_blank" title="Google Maps">`
					+ '          <i class="fa fa-globe" aria-hidden="true"></i>'
					+ '        </a>'
					+ '    </td>'
					+ `    <td>${desc}</td>`
					+ '  </tr>'
					+ '</table>';

				elementObj.bindPopup(content).openPopup();

			});

			// Zoom in on the layer if the 'zoom' option is set or zoom in on the first layer with the map's initial zoom level

			if (params.zoom || (layer_name == layers[0])) {

				if (arrMarkers.length == 1) {
					if (params.zoom) {
						map.setView(center, params.zoom);
					} else {
						map.setView(center, options.iniZoom);
					}
				} else {
					map.fitBounds(markers.getBounds());
					// Stores bounds (you can use them externally on maps in a hidden tab, e.g.)
					this.data("bounds", markers.getBounds());
				}

			}

			// If zoom level is defined controls layer visualization

			if (params.limitZoom) {

				var obj = this;

				map.on('zoomend', function () {
					if (layers.indexOf(layer_name) >= 0) {
						if (map.getZoom() < params.limitZoom) {
							map.removeLayer(markers);
						} else {
							obj.data(layer_name, markers.addTo(map));
						}
					}
				});

			} else {

				this.data(layer_name, markers.addTo(map));

			}

			return this;

		},


		removeLayer: function (layer_name) {

			if (!this.data("map")) {
				am_map_methods.init.apply(this);
			}

			var map = this.data("map");
			var layers = this.data("layers");

			if (layers.indexOf(layer_name) >= 0) {

				map.removeLayer(this.data(layer_name));

				const layer_idx = layers.indexOf(layer_name);
				if (layer_idx > -1) {
					layers.splice(layer_idx, 1);
					this.data("layers", layers);
				}

			}

			return this;

		}


	};

}(jQuery));