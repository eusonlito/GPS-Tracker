import Ajax from './ajax';
import Feather from './feather';
import LocalStorage from './local-storage';
import Map from './map';

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
        devices = JSON.parse(element.dataset.mapDevices).sort((a, b) => b.date_at > a.date_at ? -1 : 1);
    } catch (e) {
        return;
    }

    if (!devices.length) {
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

    (function () {
        const visible = element.querySelectorAll('[data-map-list-visible]');

        if (!visible.length) {
            return;
        }

        let timeout;

        const filter = () => {
            const selected = [];

            visible.forEach(checkbox => {
                if (checkbox.checked) {
                    selected.push(parseInt(checkbox.value));
                }
            });

            map.setDevices(devices.filter(device => selected.includes(device.position.id)));
        };

        const change = (element) => {
            if (!element) {
                return;
            }

            element.addEventListener('change', (e) => {
                e.preventDefault();

                clearTimeout(timeout);

                timeout = setTimeout(filter, 1000);
            });
        };


        change(element.querySelector('[data-checkall]'))

        visible.forEach(change);
    })();

    map.setDevices(devices, element.dataset.mapTripUrl);

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

        live.innerHTML = Feather('play', 'w-4 h-4 sm:w-6 sm:h-6');
    };

    const liveStart = function () {
        liveStartMap();

        interval = setInterval(liveStartMap, 10000);

        live.innerHTML = Feather('pause', 'w-4 h-4 sm:w-6 sm:h-6');
    };

    const liveStartMap = function () {
        new Ajax(element.dataset.mapDevicesUrl, 'GET')
            .setAjax(true)
            .setJsonResponse(true)
            .setCallback(liveStartMapDevices)
            .send();
    };

    const liveStartMapDevices = function (devices) {
        map.setDevices(devices);
    };
})();
