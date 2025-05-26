
/**
 * Module manages the CoordsPicker widgets
 * Each map provider should implement the AdapterInterface
 *
 * @author Chistyakov Ilya <ichistyakovv@gmail.com>
 */
(function() {

    /**
     * Interface behind the map adapter
     *
     * Produces the next list of the events on a map node:
     * - map:initialized
     * - map:click
     */
    var AdapterInterface = (function() {
        function AdapterInterface(mapNode) {
            this.mapNode = mapNode;
            this.$map = $(mapNode);
            this.map = null;
            this.zoom = 13;
        }

        /**
         * Initializes adapter just after the map script has been loaded
         */
        AdapterInterface.prototype.init = function() {};

        /**
         * Adds a new marker on the map
         *
         * @param {object} coords
         * @return {object} marker
         */
        AdapterInterface.prototype.addMarker = function(coords) {};

        /**
         * Removes marker from the map
         *
         * @param {object} marker
         */
        AdapterInterface.prototype.removeMarker = function(placemark) {};

        /**
         * Searches the place specified by the query
         *
         * @param {string} query
         * @param {function} succes callback
         * @param {function} fail callback
         */
        AdapterInterface.prototype.search = function(query, succes, fail) {};

        /**
         * Sets zoom for the map
         *
         * @param {number} zoom
         */
        AdapterInterface.prototype.setZoom = function(zoom) {};

        /**
         * Runs callback when the map provider module has been loaded
         *
         * @param {function} callback
         */
        AdapterInterface.onReady = function(callback) {};

        /**
         * Returns URL string for the map provider resource
         * that can be tuned with the specified options
         *
         * @param {object} options
         * @return {string} path
         */
        AdapterInterface.getBundle = function(options) {};

        return AdapterInterface;
    })();

    var YandexAdapter = (function() {
        function YandexAdapter(mapNode) {
            AdapterInterface.apply(this, arguments);
            this.init = this.init.bind(this);
            this._init = this._init.bind(this);
            this.onMapClick = this.onMapClick.bind(this);
            YandexAdapter.onReady(this.init);
        }

        YandexAdapter.prototype = Object.create(AdapterInterface.prototype);
        YandexAdapter.constructor.prototype = YandexAdapter;

        /**
         * @inheritdoc
         */
        YandexAdapter.prototype.init = function() {
            ymaps.ready(this._init);
        };

        YandexAdapter.prototype._init = function() {
            this.map = new ymaps.Map(this.mapNode, {
                center: [0, 0],
                zoom: this.zoom
            });

            this._bindEvents();
            this.$map.trigger('map:initialized');
        };

        YandexAdapter.prototype._bindEvents = function() {
            this.map.events.add('click', this.onMapClick);
        };

        YandexAdapter.prototype.onMapClick = function(e) {
            var coords = e.get('coords');
            this.$map.trigger('map:click', [e, coords]);
        };

        /**
         * @inheritdoc
         */
        YandexAdapter.prototype.removeMarker = function(placemark) {
            this.map.geoObjects.remove(placemark);
        };

        /**
         * @inheritdoc
         */
        YandexAdapter.prototype.addMarker = function(coords) {
            placemark = new ymaps.Placemark(coords);
            this.map.setCenter(coords, this.zoom);
            this.map.geoObjects.add(placemark);

            return placemark;
        };

        /**
         * @inheritdoc
         */
        YandexAdapter.prototype.setZoom = function(zoom) {
            this.zoom = zoom;
            this.map.setZoom(zoom);
        }

        /**
         * @inheritdoc
         */
        YandexAdapter.prototype.search = function(query, success, fail) {
            var geocoder = ymaps.geocode(query);

            geocoder.then(
                function(res) {
                    var coords = res.geoObjects.get(0).geometry.getCoordinates();
                    success(coords);
                },
                function(err) {
                    fail(err);
                }
            );
        }

        YandexAdapter.isLoaded = false;
        YandexAdapter.callbacks = [];
        YandexAdapter.timer = null;

        /**
         * @inheritdoc
         */
        YandexAdapter.onReady = function(callback) {
            if (this.isLoaded)
                return callback();

            this.callbacks.push(callback);
            this.loop();
        };

        YandexAdapter.loop = function() {
            if (this.timer)
                return;

            var _this = this;

            this.timer = setInterval(function() {
                if (typeof ymaps === 'undefined')
                    return;

                clearInterval(_this.timer);
                _this.timer = null;
                _this.isLoaded = true;
                _this.callCallbacks();
            }, 1e3/60);
        };

        YandexAdapter.callCallbacks = function() {
            for (var i = 0; i < this.callbacks.length; i++) {
                this.callbacks[i]();
            }
            this.callbacks = [];
        };

        /**
         * @inheritdoc
         */
        YandexAdapter.getBundle = function(options) {
            var bundle = '//api-maps.yandex.ru/2.1/?';
            for (i in options) {
                var option = options[i];
                switch (i) {
                    default:
                        bundle += i + '=' + option;
                        break;
                }
            }
console.log(bundle);
            return bundle;
        }

        return YandexAdapter;
    })();

    var CoordsPicker = (function() {
        function CoordsPicker($container, $mapContainer, map) {
            this.$container = $container;
            this.$map = $mapContainer;
            this.map = map;
            this.zoom = $container.data('zoom') || 13;
            this.$lat = $container.find('.coords-picker-latitude');
            this.$lon = $container.find('.coords-picker-longitude');
            this.$searchBtn = $container.find('.coords-picker-search-btn');
            this.$searchInput = $container.find('.coords-picker-address');
            this.$cityInput = $container.find('.coords-picker-city');
            this.placemark = null;

            this._bindEvents();
        }

        CoordsPicker.prototype._bindEvents = function() {
            this.onSearchBtnClick = this.onSearchBtnClick.bind(this);
            this.onMapClick = this.onMapClick.bind(this);
            this.init = this.init.bind(this);

            this.$searchBtn.on('click', this.onSearchBtnClick);
            this.$map.on('map:click', this.onMapClick);
            this.$map.on('map:initialized', this.init);
        }

        CoordsPicker.prototype.init = function() {
            var lat = this.$lat.val() || 61.400856;
            var lon = this.$lon.val() || 55.160283;

            this.map.setZoom(this.zoom);
            this.changeMarker([lat, lon]);
        }

        CoordsPicker.prototype.onSearchBtnClick = function() {
            var _this = this;
            var city = this.$cityInput.val();
            var address = this.$searchInput.val();
            var query = city ? city+", "+address : address;

            this.map.search(
                query,
                function(coords) {
                    _this.changeMarker(coords);
                },
                function(err) {
                    alert('An error occured: ' + err.message);
                }
            );
        }

        CoordsPicker.prototype.onMapClick = function(origEvent, event, coords) {
            this.changeMarker(coords);
        }

        CoordsPicker.prototype.changeMarker = function(coords) {
            if (this.placemark)
                this.map.removeMarker(this.placemark);

            this.placemark = this.map.addMarker(coords);
            this.updateCoords(coords);
        }

        CoordsPicker.prototype.updateCoords = function(coords) {
            this.$lat.val(coords[0]);
            this.$lon.val(coords[1]);
        }

        return CoordsPicker;
    })();

    var CoordsPickerManager = {
        widgets: $('.coords-picker'),
        loadedProviders: {},
        providers: {
            yandex: {
                adapter: YandexAdapter
            }
        },

        init: function() {
            var _this = this;

            this.widgets.each(function() {
                var $widgetContainer = $(this);
                var $mapContainer = $widgetContainer.find('.coords-picker-map');
                var mapProvider = $widgetContainer.data('provider');
                var adapter = _this.providers[mapProvider].adapter;

                if (!_this.loadedProviders[mapProvider]) {
                    _this.loadResources(adapter, mapProvider, $widgetContainer.data('options'));
                }

                var map = new adapter($mapContainer.get(0));
                var coordsPicker = new CoordsPicker($widgetContainer, $mapContainer, map);
            });
        },

        loadResources: function(adapter, provider, options) {
            var bundle = adapter.getBundle(options);

            this.addScript(bundle);
            this.loadedProviders[provider] = true;
        },

        addScript: function(src) {
            var elem = document.createElement('script');
            var head = document.head || document.getElementsByTagName('head')[0];

            elem.src = src;
            head.appendChild(elem);
        }
    };

    CoordsPickerManager.init();
})();
