import L from 'leaflet';
import 'leaflet-arrowheads';
import GeometryUtil from 'leaflet-geometryutil';

L.GeometryUtil = GeometryUtil;

import Ajax from './ajax';
import Feather from './feather';

(function () {
    'use strict';

    const element = document.querySelector('[data-map]');

    if (!element || !element.dataset.mapPositions) {
        return;
    }

    const render = element.querySelector('[data-map-render]');

    if (!render) {
        return;
    }

    let positions = [];

    try {
        positions = JSON.parse(element.dataset.mapPositions);
    } catch (e) {
        return;
    }

    if (!positions.length) {
        return;
    }

    const polylineAdd = function (positions, color) {
        line = L.polyline(positions, {
            color: color,
            weight: 3,
            opacity: 1
        }).arrowheads({ size: '5px', fill: true }).addTo(layer);
    }

    const trackAdd = function (point) {
        track.push([point.latitude, point.longitude]);
    }

    const markerAdd = function (point) {
        return markers[point.id] = L.circleMarker([point.latitude, point.longitude], { radius: 10, fillOpacity: 0.2, opacity: 0.3 })
            .bindPopup(jsonToHtml(point))
            .addTo(layer);
    }

    const jsonToHtml = function(json) {
        let html = '';

        Object.keys(json).forEach(function(key) {
            html += '<p style="margin: 0.5em 0 !important"><strong>' + key.replace(/_at$/, '') + ':</strong> ' + json[key] + '</p>';
        });

        return html;
    }

    function markerShow(e, point) {
        e.preventDefault();

        if (marker) {
            marker.closePopup();
        }

        marker = markers[point.dataset.mapPoint];

        if (!marker) {
            return;
        }

        map.flyTo(marker.getLatLng());

        marker.openPopup();
    }

    function iconAdd(point, name) {
        if (icon[name]) {
            map.removeLayer(icon[name]);
        }

        icon[name] = new L.Marker(point.getLatLng(), {
            icon: L.icon({
                iconUrl: '/build/images/map-' + name + '.svg',
                iconSize: [30, 42],
                iconAnchor: [15, 42],
            })
        }).addTo(map);
    }

    const layers = {
        OpenStreetMap: L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxNativeZoom: 19,
            maxZoom: 22
        }),
        GoogleStreets: L.tileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
            maxNativeZoom: 20,
            maxZoom: 22,
            subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
        }),
        GoogleSatellite: L.tileLayer('http://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}',{
            maxNativeZoom: 20,
            maxZoom: 22,
            subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
        })
    };

    let line;
    let marker;
    let icon = {};

    const map = L.map(render, {
        attributionControl: false,
        zoomControl: true,
        zoomSnap: 1
    });

    L.control.layers({ ...layers }, null, { collapsed: true }).addTo(map);

    layers.OpenStreetMap.addTo(map);

    const track = [];
    const markers = {};
    const total = positions.length;
    const layer = new L.FeatureGroup();

    positions.forEach(function (point) {
        trackAdd(point);
        markerAdd(point);
    });

    let positionFirst = positions[0];
    let positionLast = positions[positions.length - 1];

    iconAdd(markers[positionFirst.id], 'start');
    iconAdd(markers[positionLast.id], 'end');

    polylineAdd(track, '#005EB8');

    layer.addTo(map);

    if (element.dataset.mapShowLast) {
        map.setView(markers[positionLast.id].getLatLng(), 17);
    } else {
        map.fitBounds(layer.getBounds(), { animate: false, padding: [30, 30] });
        map.invalidateSize();
    }

    element.querySelectorAll('[data-map-point]').forEach(point => {
        point.addEventListener('click', (e) => markerShow(e, point));
    });

    const live = document.querySelector('[data-map-live]');

    if (!live) {
        return;
    }

    let interval;

    live.addEventListener('click', (e) => {
        e.preventDefault();

        if (interval) {
            liveStop();
        } else {
            liveStart();
        }
    });

    const liveStop = function () {
        clearInterval(interval);

        interval = null;

        live.innerHTML = Feather('play', 'w-6 h-6');
    };

    const liveStart = function () {
        liveStartMap();

        interval = setInterval(liveStartMap, 10000);

        live.innerHTML = Feather('pause', 'w-6 h-6');
    };

    const liveStartMap = function () {
        new Ajax(element.dataset.mapPositionsUrl + '?id_from=' + positionLast.id, 'GET')
            .setAjax(true)
            .setJsonResponse(true)
            .setCallback(liveStartMapPositions)
            .send();
    };

    const liveStartMapPositions = function (positions) {
        if (!positions || !positions.length) {
            return;
        }

        positions.forEach(position => {
            line.addLatLng(markerAdd(position).getLatLng());
            tableAddPosition(position);
        });

        positionLast = positions[positions.length - 1];

        iconAdd(markers[positionLast.id], 'end');

        map.flyTo(markers[positionLast.id].getLatLng());
    };

    const tableAddPosition = function (position) {
        const tbody = element.querySelector('table > tbody');
        const tr = tbody.querySelector('tr');

        const clone = tr.cloneNode(true);
        const tds = clone.querySelectorAll('td');

        tableAddPositionDate(tds[0], position);
        tableAddPositionLatitudeLongitude(tds[1], position);
        tableAddPositionSpeed(tds[2], position);
        tableAddPositionSignal(tds[3], position);

        tbody.insertBefore(clone, tr);
    };

    const tableAddPositionDate = function (td, position) {
        td.dataset.mapPoint = position.id;
        td.innerHTML = position.date_at;
    };

    const tableAddPositionLatitudeLongitude = function (td, position) {
        const a = td.querySelector('a');

        a.innerHTML = position.latitude + ',' + position.longitude;
        a.href = 'https://maps.google.com/?q=' + position.latitude + ',' + position.longitude;
    };

    const tableAddPositionSpeed = function (td, position) {
        td.innerHTML = position.speed;
    };

    const tableAddPositionSignal = function (td, position) {
        td.innerHTML = Feather(position.signal ? 'check-square' : 'square', '', !!position.signal);
    };
})();
