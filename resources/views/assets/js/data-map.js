import Ajax from './ajax';
import Feather from './feather';
import LocalStorage from './local-storage';
import Map from './map';

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
        positions = JSON.parse(element.dataset.mapPositions).sort((a, b) => b.date_at > a.date_at ? -1 : 1);
    } catch (e) {
        return;
    }

    if (!positions.length) {
        return;
    }

    const map = new Map(render);

    (function () {
        const mapListToggle = element.querySelector('[data-map-list-toggle]');

        if (!mapListToggle) {
            return;
        }

        const localStorage = new LocalStorage('map');

        mapListToggle.addEventListener('click', (e) => {
            e.preventDefault();

            const show = element.classList.contains('map-list-hidden');

            element.classList.add('map-list-moving');
            element.classList.toggle('map-list-hidden');

            mapListToggle.innerHTML = show ? '⟼' : '⟻';

            localStorage.set('list', show);

            setTimeout(() => {
                element.classList.remove('map-list-moving');
                map.invalidateSize();
            }, 500);
        });

        if (localStorage.get('list')) {
            mapListToggle.dispatchEvent(new Event('click'));
        }
    })();

    try {
        map.setAlarms(JSON.parse(element.dataset.mapAlarms || '[]'));
    } catch (e) {
    }

    try {
        map.setNotifications(JSON.parse(element.dataset.mapNotifications || '[]'));
    } catch (e) {
    }

    map.setPoints(positions);
    map.setMarkers(positions);

    const mapPointClick = function (e, point) {
        e.preventDefault();

        map.showMarker(point.dataset.mapPoint);
    };

    let positionFirst = positions[0];
    let positionLast = positions[positions.length - 1];

    map.setIcon('start', positionFirst);
    map.setIcon('end', positionLast);

    map.setListTable(document.querySelector('[data-map-list-table]'));

    if (element.dataset.mapShowLast) {
        map.setView(positionLast, 17);
    } else {
        map.fitBounds();
    }

    document.querySelectorAll('[data-map-point]').forEach(point => {
        point.addEventListener('click', (e) => mapPointClick(e, point));
    });

    const anchor = window.location.hash.substr(1);

    if (anchor.match(/^position\-id\-[0-9]+$/)) {
        map.showMarker(anchor.split('-').pop());
    }

    const live = document.querySelector('[data-map-live]');

    const distance = document.querySelector('[data-map-list-distance]');
    const time = document.querySelector('[data-map-list-time]');

    let interval;

    if (live) {
        live.addEventListener('click', (e) => {
            e.preventDefault();

            if (interval) {
                liveStop();
            } else {
                liveStart();
            }
        });
    }

    const liveStop = function () {
        clearInterval(interval);

        interval = null;

        live.innerHTML = Feather('play', 'w-4 h-4 sm:w-6 sm:h-6');
    };

    const liveStart = function () {
        liveStartMap();

        interval = setInterval(liveStartMap, 10000);

        live.innerHTML = Feather('pause', 'w-4 h-4 sm:w-6 sm:h-6');
    };

    const liveStartMap = function () {
        new Ajax(element.dataset.mapPositionsUrl + '?id_from=' + positionLast.id, 'GET')
            .setAjax(true)
            .setJsonResponse(true)
            .setCallback(liveStartMapPositions)
            .send();
    };

    const liveStartMapPositions = function (trip) {
        distance.textContent = trip.distance_human;
        time.textContent = timeHuman(trip.time);

        const positions = trip.positions;

        if (!positions || !positions.length) {
            return;
        }

        positions.forEach(position => {
            map.setPoint(position);
            map.setMarker(position);

            tableAddPosition(position);
        });

        positionLast = positions[positions.length - 1];

        map.setIcon('end', positionLast);
        map.flyTo(positionLast);
    };

    const tableAddPosition = function (position) {
        const tbody = element.querySelector('table > tbody');
        const tr = tbody.querySelector('tr');

        const clone = tr.cloneNode(true);
        const tds = clone.querySelectorAll('td');

        tableAddPositionDate(tds[0], position);
        tableAddPositionLatitudeLongitude(tds[1], position);
        tableAddPositionSpeed(tds[2], position);

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
        td.dataset.tableSortValue = position.speed;
        td.innerHTML = position.speed_human;
    };

    const timeHuman = function (seconds) {
        return ('00' + Math.floor(seconds / 3600)).slice(-2)
            + ':' + ('00' + Math.floor(seconds / 60 % 60)).slice(-2)
            + ':' + ('00' + Math.floor(seconds % 60)).slice(-2);
    };
})();
