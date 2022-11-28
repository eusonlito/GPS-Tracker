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

    positions.sort((a, b) => b.date_at > a.date_at ? -1 : 1);

    let alarms = [];

    try {
        alarms = JSON.parse(element.dataset.mapAlarms || '[]');
    } catch (e) {
        alarms = [];
    }

    let notifications = [];

    try {
        notifications = JSON.parse(element.dataset.mapNotifications || '[]');
    } catch (e) {
        notifications = [];
    }

    const ucfirst = function(string) {
        return string[0].toUpperCase() + string.slice(1);
    };

    const polylineAdd = function (positions, color) {
        line = L.polyline(positions, {
            color: color,
            weight: 3,
            opacity: 1
        }).arrowheads({ size: '5px', fill: true }).addTo(layer);
    };

    const trackAdd = function (point) {
        track.push([point.latitude, point.longitude]);
    };

    const markerAdd = function (point) {
        return markers[point.id] = L.circleMarker([point.latitude, point.longitude], { radius: 10, fillOpacity: 0.2, opacity: 0.3 })
            .bindPopup(jsonToHtml(point))
            .addTo(layer);
    };

    const alarmAdd = function (alarm) {
        if (!['fence-in', 'fence-out'].includes(alarm.type)) {
            return;
        }

        const lat = parseFloat(alarm.config.latitude);
        const lng = parseFloat(alarm.config.longitude);
        const radius = parseFloat(alarm.config.radius);

        if (isNaN(lat) || isNaN(lng) || isNaN(radius) || !lat || !lng || !radius) {
            return;
        }

        L.circle({ lat, lng }, {
            radius: radius * 1000,
            fillOpacity: 0.05,
            opacity: 0.3,
            color: (alarm.type === 'fence-in') ? 'red' : 'green',
            fillColor: (alarm.type === 'fence-in') ? 'red' : 'green',
        }).addTo(map);
    };

    const notificationAdd = function (notification) {
        const lat = parseFloat(notification.latitude);
        const lng = parseFloat(notification.longitude);

        if (!notification.type || isNaN(lat) || isNaN(lng) || !lat || !lng) {
            return;
        }

        new L.Marker({ lat, lng }, {
            icon: L.icon({
                iconUrl: '/build/images/map-notification-' + notification.type + '.svg',
                iconSize: [30, 42],
                iconAnchor: [15, 42],
            })
        }).addTo(map);
    };

    const jsonToHtml = function(json) {
        let html = '';

        Object.keys(json).forEach(function(key) {
            html += '<p style="margin: 0.5em 0 !important"><strong>' + ucfirst(key.replace(/_at$/, '')) + ':</strong> ' + json[key] + '</p>';
        });

        return html;
    };

    const mapPointClick = function (e, point) {
        e.preventDefault();

        markerShow(point.dataset.mapPoint);
    };

    const markerShow = function (id) {
        if (marker) {
            marker.closePopup();
        }

        marker = markers[id];

        if (!marker) {
            return;
        }

        map.flyTo(marker.getLatLng());

        marker.openPopup();
    };

    const iconAdd = function (point, name) {
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
    };

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

    alarms.forEach(function (alarm) {
        alarmAdd(alarm);
    });

    notifications.forEach(function (notification) {
        notificationAdd(notification);
    });

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

    document.querySelectorAll('[data-map-point]').forEach(point => {
        point.addEventListener('click', (e) => mapPointClick(e, point));
    });

    const anchor = window.location.hash.substr(1);

    if (anchor.match(/^position\-id\-[0-9]+$/)) {
        markerShow(anchor.split('-').pop());
    }

    const live = document.querySelector('[data-map-live]');

    if (!live) {
        return;
    }

    const distance = document.querySelector('[map-list-distance]');
    const time = document.querySelector('[map-list-time]');

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

    const liveStartMapPositions = function (trip) {
        distance.textContent = distanceHuman(trip.distance);
        time.textContent = timeHuman(trip.time);

        const positions = trip.positions;

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

    const distanceHuman = function (meters) {
        let decimals = 2,
            units = 'km';

        if (meters >= 1000) {
            meters /= 1000;
        } else {
            decimals = 0;
            units = 'm';
        }

        return new Intl.NumberFormat('es-ES', {
            minimumFractionDigits: decimals,
            maximumFractionDigits: decimals
        }).format(meters) + ' ' + units;
    };

    const timeHuman = function (seconds) {
        return ('00' + Math.floor(seconds / 3600)).slice(-2)
            + ':' + ('00' + Math.floor(seconds / 60 % 60)).slice(-2)
            + ':' + ('00' + Math.floor(seconds % 60)).slice(-2);
    };
})();
