import L from 'leaflet';
import GeometryUtil from 'leaflet-geometryutil';
import Map from './map';

L.GeometryUtil = GeometryUtil;

(function () {
    'use strict';

    const element = document.querySelector('[data-map-fence]');

    if (!element) {
        return;
    }

    const latitude = document.querySelector(element.dataset.mapFenceLatitude);
    const longitude = document.querySelector(element.dataset.mapFenceLongitude);
    const radius = document.querySelector(element.dataset.mapFenceRadius);

    if (!latitude || !longitude || !radius) {
        return
    }

    latitude.value = latitude.value || 40.416729;
    longitude.value = longitude.value || -3.703339;
    radius.value = radius.value || 5;

    let circle;

    const mapClick = function (lat, lng, input) {
        lat = parseFloat(lat).toFixed(5);
        lng = parseFloat(lng).toFixed(5);

        if (circle) {
            map.removeLayer(circle);
        }

        circle = L.circle({ lat, lng }, {
            radius: radius.value * 1000,
            fillOpacity: 0.2,
            opacity: 0.3
        }).addTo(map);

        if (input) {
            map.setView({ lat, lng });
        } else {
            latitude.value = lat;
            longitude.value = lng;
        }
    }

    const layers = Map.getControlLayers();

    const map = L.map(element, {
        attributionControl: false,
        zoomControl: true,
        zoomSnap: 1,
        zoom: 13
    });

    L.control.layers({ ...layers }, null, { collapsed: true }).addTo(map);

    layers.OpenStreetMap.addTo(map);

    mapClick(latitude.value, longitude.value, true);

    if (element.offsetParent !== null) {
        map.fitBounds(map.getBounds(), { animate: false, padding: [30, 30] });
    }

    map.on('click', e => mapClick(e.latlng.lat, e.latlng.lng));

    latitude.addEventListener('keyup', (e) => mapClick(latitude.value, longitude.value, true));
    longitude.addEventListener('keyup', (e) => mapClick(latitude.value, longitude.value, true));
    radius.addEventListener('keyup', (e) => mapClick(latitude.value, longitude.value, true));

    window.map = map;
})();
