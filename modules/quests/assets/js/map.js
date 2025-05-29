(function () {
    var lat, lng, coords, latField, lngField, placemark, map;

    var searchButton = document.querySelector('.coords-picker-search-btn');
    searchButton.addEventListener('click', () => {
        var address = document.querySelector('.coords-picker-address').value;
        searchCoords(address);
    });

    latField = document.querySelector('.coords-picker-latitude');
    lngField = document.querySelector('.coords-picker-longitude');
    lat = latField.value || 55.167822;
    lng = lngField.value || 61.411712;

    coords = [lat, lng];

    var changePoint = function(coords) {
        latField.value = coords[0];
        lngField.value = coords[1];
        placemark.geometry.setCoordinates(coords);
    }

    var searchCoords = function(addr) {
        var myGeocoder = ymaps.geocode(addr);
        var coords = null;
        myGeocoder.then((res) => {
            coords = res.geoObjects.get(0).geometry.getCoordinates();
            changePoint(coords);
            setCenter(coords);
        });
    };

    var setCenter = function(coords) {
        map.setCenter(coords);
    };

    var init = function () {
        var search = new ymaps.control.SearchControl({
            options: {
                noPlacemark: true,
                provider: 'yandex#map'
            }
        });

        map = new ymaps.Map("map-picker", {
            center: coords,
            zoom: 16,
            controls: [search, new ymaps.control.ZoomControl()]
        }, {
            balloonMaxWidth: 200,
            suppressMapOpenBlock: true
        });

        map.cursors.push('pointer');

        placemark = new ymaps.Placemark(coords);
        map.geoObjects.add(placemark);
        map.events.add('click', function (e) {
            var newCoords = e.get('coords');
            changePoint(newCoords);
        });

        search.events.add("resultselect", function (e) {
            var selected = search.getResultsArray();
            selected = selected[e.get("index")];
            var newCoords = selected.geometry.getCoordinates();
            changePoint(newCoords);
        });
    }

    ymaps.ready(init);
})();
