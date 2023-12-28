import L from 'leaflet';
import GeometryUtil from 'leaflet-geometryutil';
import 'leaflet-draw';
import Map from './map';

L.GeometryUtil = GeometryUtil;

(function () {
    'use strict';

    const element = document.querySelector('[data-map-polygon]');

    if (!element) {
        return;
    }

    const input = document.querySelector(element.dataset.mapPolygonInput);

    if (!input) {
        return;
    }

    const latitude = element.dataset.mapPolygonLatitude || 40.416729;
    const longitude = element.dataset.mapPolygonLongitude || -3.703339;

   const layers = Map.getControlLayers();

    const map = L.map(element, {
        attributionControl: false,
        zoomControl: true,
        zoomSnap: 1,
        center: new L.LatLng(latitude, longitude),
        zoom: 13
    });

    L.control.layers({ ...layers }, null, { collapsed: true }).addTo(map);

    layers.OpenStreetMap.addTo(map);

    const drawnItems = new L.FeatureGroup();

    map.addLayer(drawnItems);

    const drawControlFull = new L.Control.Draw({
        draw: {
            polyline: false,
            circle: false,
            rectangle: false,
            marker: false,
            circlemarker: false,
            polygon: {
                allowIntersection: false,
                drawError: {
                    color: "#e1e100",
                    message: "<strong>Not Available<strong>"
                },
                shapeOptions: {
                    color: "#97009c"
                }
            },
            poly: {
                allowIntersection: false
            }
        },

        edit: {
            featureGroup: drawnItems,
            remove: false,
            poly: {
                allowIntersection: false
            }
        }
    });

    const drawControlEditOnly = new L.Control.Draw({
        draw: false,

        edit: {
            featureGroup: drawnItems,

            polygon: {
                allowIntersection: false,

                drawError: {
                    color: '#e1e100',
                    message: '<strong>Not Available<strong>'
                },
                shapeOptions: {
                    color: '#97009c'
                }
            },

            poly: {
                allowIntersection: false,
            }
        },
    });

    map.addControl(drawControlFull);

    const loadGeoJson = (geojson) => {
        if (!geojson || !geojson.length) {
            return;
        }

        L.geoJson(JSON.parse(geojson), {
            onEachFeature: (feature, layer) => drawnItems.addLayer(layer)
        });

        if (!drawnItems.getLayers().length) {
            return;
        }

        map.removeControl(drawControlFull);
        map.addControl(drawControlEditOnly);

        map.fitBounds(drawnItems.getLayers()[0].getBounds(), { animate: false, padding: [30, 30] });
    };

    try {
        loadGeoJson(input.value);
    } catch (e) {
        console.error(e);
    }

    map.on('draw:created', function (e) {
        e.layer.editing.enable();

        drawnItems.addLayer(e.layer);

        map.removeControl(drawControlFull);
        map.addControl(drawControlEditOnly);
    });

    map.on('draw:deleted', function(e) {
        setInputValue(e);

        if (drawnItems.getLayers().length) {
            return;
        }

        map.removeControl(drawControlEditOnly);
        map.addControl(drawControlFull);
    });

    const setInputValue = (e) => {
        const geoJson = drawnItems.toGeoJSON();

        input.value = geoJson.features.length ? JSON.stringify(geoJson) : '';
    }

    map.on('draw:edited', setInputValue);
    map.on('draw:editstop', setInputValue);
    map.on('draw:drawstop', setInputValue);

    window.map = map;
})();
