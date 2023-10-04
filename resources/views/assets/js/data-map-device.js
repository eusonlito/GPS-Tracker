import Ajax from './ajax';
import Feather from './feather';
import LocalStorage from './local-storage';
import Map from './map';
import { dateUtc, dateToIso } from './helper'

(function () {
    'use strict';

    const element = document.querySelector('[data-map-devices]');

    if (!element || !element.dataset.mapDevices) {
        return;
    }

    const render = element.querySelector('[data-map-render]');

    if (!render) {
        return;
    }

    let devices = [];

    try {
        devices = JSON.parse(element.dataset.mapDevices)
            .filter(device => device.position)
            .sort((a, b) => a.name < b.name ? -1 : 1);
    } catch (e) {
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

    const filterVisible = element.querySelectorAll('[data-map-list-visible]');
    const filterFinished = element.querySelector('[data-map-trip-finished]');

    const filter = () => {
        map.setDevices(filterFinishedHandler(filterVisibleHandler(devices)));
    };

    const filterVisibleHandler = (devices) => {
        if (!filterVisible.length) {
            return devices;
        }

        const selected = [];

        filterVisible.forEach(checkbox => {
            if (checkbox.checked) {
                selected.push(parseInt(checkbox.value));
            }
        });

        return devices.filter(device => selected.includes(device.position.id));
    };

    const filterFinishedHandler = (devices) => {
        if (!filterFinished) {
            return devices;
        }

        const end_at = dateToIso(dateUtc(new Date(new Date() - 1000 * filterFinished.value)));
        const value = filterFinished.value;

        return devices.filter(device => {
            const date_utc_at = device.position.date_utc_at;

            if (value === '0') {
                return date_utc_at >= end_at;
            }

            if (value === '1') {
                return date_utc_at <= end_at;
            }

            return true;
        });
    };

    const filterListener = () => {
        filterVisibleListener();
        filterFinishedListener();
    };

    const filterVisibleListener = () => {
        if (!filterVisible.length) {
            return;
        }

        let timeout;

        const event = (e) => {
            e.preventDefault();

            clearTimeout(timeout);

            timeout = setTimeout(filter, 800);
        };

        filterVisible.forEach((checkbox) => {
            if (checkbox) {
                checkbox.addEventListener('change', event);
            }
        });
    };

    const filterFinishedListener = () => {
        if (!filterFinished) {
            return;
        }

        let timeout;

        filterFinished.addEventListener('change', (e) => {
            e.preventDefault();

            clearTimeout(timeout);

            timeout = setTimeout(filter, 800);
        });
    };

    filterListener();

    map.setDevicesTripUrl(element.dataset.mapTripUrl);
    map.setDevices(devices);

    const mapPointClick = function (e, point) {
        e.preventDefault();

        map.showMarker(point.dataset.mapPoint);
    };

    map.setListTable(document.querySelector('[data-map-list-table]'));

    if (devices.length) {
        map.fitBounds();
    }

    document.querySelectorAll('[data-map-point]').forEach(point => {
        point.addEventListener('click', (e) => mapPointClick(e, point));
    });

    const live = document.querySelector('[data-map-live]');

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

        live.innerHTML = Feather('play', 'w-6 h-6');
    };

    const liveStart = function () {
        liveStartMap();

        interval = setInterval(liveStartMap, 10000);

        live.innerHTML = Feather('pause', 'w-6 h-6');
    };

    const liveStartMap = function () {
        new Ajax(window.location.href, 'GET')
            .setAjax(true)
            .setJsonResponse(true)
            .setCallback(liveStartMapDevices)
            .send();
    };

    const liveStartMapDevices = function (response) {
        filter(devices = response);
    };
})();
