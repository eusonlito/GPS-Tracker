import L from 'leaflet';
import HeatmapOverlay from 'leaflet-heatmap';
import GeometryUtil from 'leaflet-geometryutil';
import Ajax from './ajax';
import Map from './map';

L.GeometryUtil = GeometryUtil;

(function () {
    'use strict';

    const element = document.querySelector('[data-map-heat]');

    if (!element || !element.dataset.mapHeatForm) {
        return;
    }

    const form = document.querySelector(element.dataset.mapHeatForm);

    if (!form) {
        return;
    }

    let bbox = [];

    try {
        bbox = JSON.parse(element.dataset.mapHeatBbox);
    } catch (e) {
        return;
    }

    let grid = [];

    try {
        grid = JSON.parse(element.dataset.mapHeatGrid);
    } catch (e) {
        return;
    }

    if (!bbox || !grid) {
        return
    }

    let timeout;

    const getMapBounds = () => {
        const bounds = map.getBounds();

        return {
            latitude_min: bounds._southWest.lat,
            longitude_min: bounds._southWest.lng,
            latitude_max: bounds._northEast.lat,
            longitude_max: bounds._northEast.lng,
        };
    };

    const update = () => {
        clearTimeout(timeout);

        timeout = setTimeout(() => {
            new Ajax(window.location.href, 'POST')
                .setAjax(true)
                .setQuery({ bounding_box: getMapBounds() })
                .setBodyForm(form)
                .setJsonResponse(true)
                .setCallback(updateCallback)
                .send();
        }, 1000);
    };

    const updateCallback = (grid) => {
        heatmapLayerSetData(grid);
    };

    const heatmapLayerSetData = (data) => {
        heatmapLayer.setData({ max: 100, data });
    };

    const mapfitBounds = (bbox) => {
        map.fitBounds([[bbox.latitude_max, bbox.longitude_max], [bbox.latitude_min, bbox.longitude_min]], {
            animate: false,
            padding: [30, 30]
        });
    };

    const layers = Map.getControlLayers();

    const heatmapLayer = new HeatmapOverlay({
        radius: 12,
        maxOpacity: .5,
        scaleRadius: false,
        useLocalExtrema: true,
        latField: 'cell_y',
        lngField: 'cell_x',
        valueField: 'value'
    });

    heatmapLayerSetData(grid);

    const map = L.map(element, {
        attributionControl: false,
        zoomControl: true,
        zoomSnap: 1,
        layers: [heatmapLayer]
    });

    L.control.layers({ ...layers }, null, { collapsed: true }).addTo(map);

    layers.OpenStreetMap.addTo(map);

    mapfitBounds(bbox);

    map.on('moveend zoomend', update);

    window.map = map;
})();
