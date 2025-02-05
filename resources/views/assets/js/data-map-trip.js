import Ajax from './ajax';
import Feather from './feather';
import Storage from './storage';
import Map from './map';
import number2color from './number2color';
import { dateUtc, dateToIso } from './helper';

(function () {
    'use strict';

    const element = document.querySelector('[data-map-trip]');

    if (!element || !element.dataset.mapTripForm) {
        return;
    }

    const form = document.querySelector(element.dataset.mapTripForm);

    if (!form) {
        return;
    }

    const render = element.querySelector('[data-map-render]');

    if (!render) {
        return;
    }

    const map = new Map(render);

    (function () {
        const mapListToggle = element.querySelector('[data-map-list-toggle]');

        if (!mapListToggle) {
            return;
        }

        const storage = new Storage('map-trip');

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

    const update = () => {
        new Ajax(window.location.href, 'POST')
            .setAjax(true)
            .setBodyForm(form)
            .setJsonResponse(true)
            .setCallback(updateCallback)
            .send();
    };

    const updateCallback = (list) => {
        if (!list || !list.length) {
            return;
        }

        map.setTrips(list);
        map.fitBounds();

        list.forEach(tableAddTrip);

        map.setSpeeds();
        map.setLinePoints();
    };

    update();

    const tableAddTrip = function (trip) {
        const tbody = element.querySelector('table > tbody');

        if (tbody.querySelector('tr').length > 1) {
            return;
        }

        const tr = tbody.querySelector('tr.hidden');

        const clone = tr.cloneNode(true);
        const tds = clone.querySelectorAll('td');

        tds[0].style.backgroundColor = number2color(trip.id, 0.8);

        tableAddTripSelected(tds, trip, tbody);
        tableAddTripStartAt(tds, trip, tbody);
        tableAddTripDistanceHuman(tds, trip);
        tableAddTripTimeHuman(tds, trip);
        tableAddTripDevice(tds, trip);
        tableAddTripVehicle(tds, trip);
        tableAddTripUser(tds, trip);
        tableAddTripUpdate(tds, trip);

        tr.parentNode.insertBefore(clone, tbody.lastElementChild.nextSibling);

        clone.classList.remove('hidden');
    };

    const tableAddTripSelected = function (tds, trip, tbody) {
        const input = tds[0].querySelector('input');

        input.value = trip.id;

        input.addEventListener('change', (e) => {
            e.preventDefault();

            const ids = [];

            tbody.querySelectorAll('input[name="selected[]"]').forEach(input => {
                if (input.checked && input.value) {
                    ids.push(parseInt(input.value));
                }
            });

            map.setTripsIds(ids);
        });
    };

    const tableAddTripStartAt = function (tds, trip) {
        tds[1].innerHTML = trip.start_at;
    };

    const tableAddTripDistanceHuman = function (tds, trip) {
        tds[2].innerHTML = trip.distance_human;
        tds[2].dataset.tableSortValue = trip.distance;
    };

    const tableAddTripTimeHuman = function (tds, trip) {
        tds[3].innerHTML = trip.time_human;
        tds[3].dataset.tableSortValue = trip.time;
    };

    const tableAddTripDevice = function (tds, trip) {
        tds[4].innerHTML = trip.device?.name;
    };

    const tableAddTripVehicle = function (tds, trip) {
        tds[5].innerHTML = trip.vehicle?.name;
        tds[6].innerHTML = trip.vehicle?.plate;
    };

    const tableAddTripUser = function (tds, trip) {
        tds[7].innerHTML = trip.user?.name;
    };

    const tableAddTripUpdate = function (tds, trip) {
        const a = tds[8].querySelector('a');

        a.href = a.href.replace(/0$/, trip.id);
    };
})();
