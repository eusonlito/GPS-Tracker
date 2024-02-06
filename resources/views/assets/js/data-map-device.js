import Ajax from './ajax';
import Feather from './feather';
import Storage from './storage';
import Map from './map';
import { dateUtc, dateToIso } from './helper'

(function () {
    'use strict';

    const element = document.querySelector('[data-map-device]');

    if (!element || !element.dataset.mapDeviceList || !element.dataset.mapDeviceList.length) {
        return;
    }

    const render = element.querySelector('[data-map-render]');

    if (!render) {
        return;
    }

    let devices = [];

    try {
        devices = JSON.parse(element.dataset.mapDeviceList)
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

        const storage = new Storage('map-device');

        mapListToggle.addEventListener('click', (e) => {
            e.preventDefault();

            const show = element.classList.contains('map-list-hidden');

            element.classList.add('map-list-moving');
            element.classList.toggle('map-list-hidden');

            mapListToggle.innerHTML = show ? '⟼' : '⟻';

            storage.set('list', show);

            setTimeout(() => {
                element.classList.remove('map-list-moving');
                map.invalidateSize();
            }, 500);
        });

        if (storage.get('list')) {
            mapListToggle.dispatchEvent(new Event('click'));
        }
    })();

    const filterVisible = element.querySelectorAll('[data-map-list-visible]');
    const filterFinished = element.querySelector('[data-map-trip-finished]');

    const update = () => {
        new Ajax(window.location.href, 'GET')
            .setAjax(true)
            .setQuery(updateQuery())
            .setJsonResponse(true)
            .setCallback(updateCallback)
            .send();
    };

    const updateQuery = () => {
        return {
            ids: updateQueryIds(),
            finished: updateQueryFinished()
        };
    };

    const updateQueryIds = () => {
        if (!filterVisible.length) {
            return;
        }

        return Array.from(filterVisible)
            .filter(checkbox => checkbox.checked)
            .map(checkbox => checkbox.value);
    };

    const updateQueryFinished = () => {
        return filterFinished?.value;
    };

    const updateCallback = (list) => {
        map.setDevices(list);
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

            timeout = setTimeout(update, 800);
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

            timeout = setTimeout(update, 800);
        });
    };

    filterListener();

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

        Feather(live, 'play')
    };

    const liveStart = function () {
        update();

        interval = setInterval(update, 10000);

        Feather(live, 'pause')
    };
})();
