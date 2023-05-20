import L from 'leaflet';

import 'leaflet-rotatedmarker';

import GeometryUtil from 'leaflet-geometryutil';

L.GeometryUtil = GeometryUtil;

import leafletPolycolor from 'leaflet-polycolor';

leafletPolycolor(L);

import Ajax from './ajax';
import Feather from './feather';
import LocalStorage from './local-storage';
import value2color from './value2color';

export default class {
    constructor(element) {
        this.setup();

        this.setElement(element);

        return this;
    }

    setup() {
        this.element = null;

        this.map = null;
        this.mapOptions = {};

        this.layer = null;
        this.layerMarkers = null;

        this.point = [];
        this.pointLatLng = [];

        this.zoom = 13;

        this.speeds = [];

        this.icons = {};

        this.alarms = [];

        this.notifications = [];

        this.points = [];

        this.marker = null;
        this.markers = {};

        this.listTable = null;

        this.localStorage = new LocalStorage('map');

        return this;
    }

    getMap() {
        if (!this.map) {
            this.setMap();
        }

        return this.map;
    }

    setMap() {
        this.map = L.map(this.getElement(), this.getMapOptions());

        this.setControls();

        return this;
    }

    getLayer() {
        if (!this.layer) {
            this.setLayer();
        }

        return this.layer;
    }

    setLayer() {
        this.layer = new L.FeatureGroup()

        this.layer.addTo(this.getMap());
        this.layer.bringToFront();

        return this;
    }

    getLayerMarkers() {
        if (!this.layerMarkers) {
            this.setLayerMarkers();
        }

        return this.layerMarkers;
    }

    setLayerMarkers() {
        this.layerMarkers = new L.FeatureGroup();

        return this;
    }

    getLayerLocate() {
        if (!this.layerLocate) {
            this.setLayerLocate();
        }

        return this.layerLocate;
    }

    setLayerLocate() {
        this.layerLocate = new L.FeatureGroup();

        return this;
    }

    setControls() {
        this.setControlLayers();
        this.setControlLayerDefault();
        this.setControlMarkers();
        this.setControlLocate();
        this.setControlScale();
    }

    getControlLayers() {
        return {
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
            }),
            CartoDBVoyager: L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png',{
                maxNativeZoom: 20,
                maxZoom: 22,
                subdomains: 'abcd'
            })
        };
    }

    setControlLayers() {
        L.control.layers(this.getControlLayers(), null, { position: 'topright', collapsed: true })
            .addTo(this.getMap());

        this.getMap().on('baselayerchange', (e) => {
            this.localStorage.set('layer', e.name);
        });

        return this;
    }

    setControlLayerDefault() {
        const layers = this.getControlLayers();
        let name = this.localStorage.get('layer');

        if (!name || !layers[name]) {
            name = Object.keys(layers)[0];
        }

        layers[name].addTo(this.getMap());

        return this;
    }

    setControlMarkers() {
        this.setControlMarkersCreate();
        this.setControlMarkersLoad();
    }

    setControlMarkersCreate() {
        const container = this.setControlMarkersCreateContainer();

        L.Control.Markers = L.Control.extend({ onAdd: () => container });
        L.control.markers = (options) => new L.Control.Markers(options);

        if (this.localStorage.get('markers') === true) {
            container.dispatchEvent(new Event('click'));
        }

        return this;
    }

    setControlMarkersCreateContainer() {
        const container =  L.DomUtil.create('div', 'leaflet-control-layers leaflet-control');
        const img = this.setControlMarkersCreateImg(container);

        const map = this.getMap();
        const layerMarkers = this.getLayerMarkers();

        container.onclick = (e) => {
            e.stopPropagation();

            if (map.hasLayer(layerMarkers)) {
                img.style.background = '#CCC';

                map.removeLayer(layerMarkers);

                this.localStorage.set('markers', false);
            } else {
                img.style.background = '#A3EA9A';

                layerMarkers.addTo(map);
                layerMarkers.bringToBack();

                this.localStorage.set('markers', true);
            }
        };

        container.ondblclick = container.onclick;

        return container;
    }

    setControlMarkersCreateImg(container) {
        const img = L.DomUtil.create('img', null, container);

        img.src = WWW + '/build/images/map-direction.svg';
        img.style.width = '44px';
        img.style.height = '44px';
        img.style.background = '#CCC';
        img.style.padding = '10px';

        return img;
    }

    setControlMarkersLoad() {
        L.control.markers({ position: 'topright' }).addTo(this.getMap());

        return this;
    }

    setControlLocate() {
        L.control.locate(this.setControlLocateOptions()).addTo(this.getMap());

        return this;
    }

    setControlLocateOptions() {
        return {
            setView: 'once',
            flyTo: true,
            keepCurrentZoomLevel: true,
            initialZoomLevel: false,
            locateOptions: {
                watch: true,
                enableHighAccuracy: true
            },
            strings: {
                title: ''
            }
        };
    }

    setControlScale() {
        L.control.scale({ imperial: false }).addTo(this.getMap());

        return this;
    }

    getElement() {
        return this.element;
    }

    setElement(element) {
        this.element = element;

        return this;
    }

    setMapOptions(options) {
        this.mapOptions = this.getMapOptions(options);

        return this;
    }

    getMapOptions(options) {
        const defaults = {
            preferCanvas: true,
            attributionControl: false,
            zoomControl: true,
            zoomSnap: 0.5,
            zoomDelta: 0.5,
            wheelPxPerZoomLevel: 200
        };

        return this.merge(defaults, options || this.mapOptions);
    }

    getPoints() {
        return this.points;
    }

    setPoints(points) {
        this.array(points).forEach((point) => this.setPoint(point));

        this.setSpeeds();
        this.setLinePoints();

        return this;
    }

    setPoint(point) {
        if (!this.isValidPoint(point)) {
            return this;
        }

        this.getPoints().push(point);

        return this;
    }

    isValidPoint(point) {
        return point && point.id && point.latitude && point.longitude;
    }

    getZoom() {
        return this.zoom;
    }

    setZoom(zoom) {
        this.zoom = zoom;

        return this;
    }

    getSpeeds() {
        return this.speeds;
    }

    setSpeeds(speeds) {
        this.speeds =  this.getPoints().map(point => point.speed);

        const speedMin = Math.min(...this.speeds);
        const speedMax = Math.max(...this.speeds);

        this.setColors(this.speeds.map(speed => value2color(speed, speedMin, speedMax)));

        return this;
    }

    getColors() {
        return this.colors;
    }

    setColors(colors) {
        this.colors = this.array(colors);

        return this;
    }

    setAlarms(alarms, options) {
        this.array(alarms).forEach(alarm => this.setAlarm(alarm, options));

        return this;
    }

    setAlarm(alarm, options) {
        if (!this.isValidAlarm(alarm)) {
            return this;
        }

        this.alarms.push(alarm);

        switch (alarm.type) {
            case 'fence-in':
                this.setAlarmFenceIn(alarm, options);
                break;

            case 'fence-out':
                this.setAlarmFenceOut(alarm, options);
                break;

            case 'polygon-in':
                this.setAlarmPolygonIn(alarm, options);
                break;

            case 'polygon-out':
                this.setAlarmPolygonOut(alarm, options);
                break;
        }

        return this;
    }

    setAlarmFenceIn(alarm, options) {
        L.circle(this.getLatLng(alarm.config), this.getAlarmOptions(alarm, options))
            .addTo(this.getMap());
    }

    setAlarmFenceOut(alarm, options) {
        L.circle(this.getLatLng(alarm.config), this.getAlarmOptions(alarm, options))
            .addTo(this.getMap());
    }

    setAlarmPolygonIn(alarm, options) {
        L.geoJson(alarm.config.geojson, {
            style: this.getAlarmOptions(alarm, options),
            onEachFeature: (feature, layer) => this.getMap().addLayer(layer)
        });
    }

    setAlarmPolygonOut(alarm, options) {
        L.geoJson(alarm.config.geojson, {
            style: this.getAlarmOptions(alarm, options),
            onEachFeature: (feature, layer) => this.getMap().addLayer(layer)
        });
    }

    isValidAlarm(alarm) {
        if (!alarm || !alarm.type || !alarm.id || !alarm.config) {
            return false;
        }

        let valid = false;

        switch (alarm.type) {
            case 'fence-in':
                valid = this.isValidAlarmFenceIn(alarm);
                break;

            case 'fence-out':
                valid = this.isValidAlarmFenceOut(alarm);
                break;

            case 'polygon-in':
                valid = this.isValidAlarmPolygonIn(alarm);
                break;

            case 'polygon-out':
                valid = this.isValidAlarmPolygonOut(alarm);
                break;
        }

        return (valid === true) && this.isValidAlarmNotLoaded(alarm);
    }

    isValidAlarmFenceIn(alarm) {
        return !!(alarm.config.latitude && alarm.config.longitude && alarm.config.radius);
    }

    isValidAlarmFenceOut(alarm) {
        return !!(alarm.config.latitude && alarm.config.longitude && alarm.config.radius);
    }

    isValidAlarmPolygonIn(alarm) {
        return !!alarm.config.geojson;
    }

    isValidAlarmPolygonOut(alarm) {
        return !!alarm.config.geojson;
    }

    isValidAlarmNotLoaded(alarm) {
        for (let i = 0; i < this.alarms.length; i++) {
            if (this.isSameAlarm(this.alarms[i], alarm)) {
                return false;
            }
        }

        return true;
    }

    isSameAlarm(loaded, current) {
        return (loaded.type === current.type)
            && (loaded.config === current.config);
    }

    getAlarmOptions(alarm, options) {
        const defaults = {
            radius: parseFloat(alarm.config.radius) * 1000,
            fillOpacity: 0.05,
            opacity: 0.3,
            color: alarm.type.match(/-in$/) ? 'red' : 'green',
            fillColor: alarm.type.match(/-in$/) ? 'red' : 'green',
        };

        return this.merge(defaults, options);
    }

    setNotifications(notifications, options) {
        this.array(notifications).forEach(notification => this.setNotification(notification, options));

        return this;
    }

    setNotification(notification, options) {
        if (!this.isValidNotification(notification)) {
            return this;
        }

        this.setAlarm(notification);

        const onClick = () => this.showMarker(this.getPointByLatitudeLongitude(notification.latitude, notification.longitude)?.id);

        new L.Marker(this.getLatLng(notification), this.getNotificationOptions(notification, options))
            .on('click', onClick)
            .addTo(this.getMap());

        return this;
    }

    isValidNotification(notification) {
        return notification && notification.type && notification.latitude && notification.longitude;
    }

    getNotificationOptions(notification, options) {
        const defaults = {
            iconUrl: WWW + '/build/images/map-notification-' + notification.type + '.svg',
            iconSize: [30, 42],
            iconAnchor: [15, 42],
        };

        return { icon: L.icon(this.merge(defaults, options)) };
    }

    setIcon(name, point, options) {
        if (this.icons[name]) {
            this.getMap().removeLayer(this.icons[name]);
        }

        this.icons[name] = new L.Marker(this.getLatLng(point), this.getIconOptions(name, options))
            .on('click', (e) => this.showMarker(point.id))
            .addTo(this.getMap());

        return this;
    }

    getIconOptions(name, options) {
        const defaults = {
            iconUrl: WWW + '/build/images/map-' + name + '.svg',
            iconSize: [30, 42],
            iconAnchor: [15, 42],
        };

        return { icon: L.icon(this.merge(defaults, options)) };
    }

    setLinePoints() {
        this.setLine(this.points.map((point) => this.getLatLng(point)));

        return this;
    }

    setLine(points) {
        this.setLinePolycolor(points);

        return this;
    }

    setLinePolycolor(points, lineOptions) {
        if (this.line) {
            this.getMap().removeLayer(this.line);
        }

        this.line = L.polycolor(points, this.getLineOptions(lineOptions))
            .addTo(this.getLayer());

        return this;
    }

    getLineOptions(options) {
        const defaults = {
            colors: this.getColors(),
            useGradient: true,
            weight: 5,
            opacity: 1,
            smoothFactor: 1
        };

        return this.merge(defaults, options);
    }

    setMarkers(markers, options) {
        this.array(markers).forEach(marker => this.setMarker(marker, options));

        return this;
    }

    setMarker(marker, options, optionsIcon) {
        if (!this.isValidMarker(marker)) {
            return this;
        }

        const latLng = this.getLatLng(marker);
        const html = this.popupHtml(marker);

        L.marker(latLng, this.getMarkerOptions(marker, options, optionsIcon))
            .bindPopup(html)
            .on('click', (e) => this.showMarker(marker.id))
            .addTo(this.getLayerMarkers());

        this.markers[marker.id] = L.circleMarker(latLng, { radius: 15, opacity: 0, fillOpacity: 0 })
            .bindPopup(html)
            .on('click', (e) => this.showMarker(marker.id))
            .addTo(this.getLayer());

        return this;
    }

    isValidMarker(marker) {
        return marker && marker.id && marker.latitude && marker.longitude;
    }

    getMarkerOptions(marker, options, optionsIcon) {
        const defaults = {
            rotationAngle: marker.direction || 0,
            rotationOrigin: 'center',
            opacity: 0.95
        };

        const defaultsIcon = {
            iconUrl: WWW + '/build/images/map-direction.svg',
            iconSize: [10, 10],
            iconAnchor: [5, 5]
        };

        return {
            ...this.merge(defaults, options),
            icon: L.icon(this.merge(defaultsIcon, optionsIcon))
        };
    }

    showMarker(id) {
        if (this.marker) {
            this.marker.closePopup();
        }

        this.marker = this.markers[id];

        if (!this.marker) {
            return this;
        }

        this.getMap().flyTo(this.marker.getLatLng());

        this.showMarkerListTable(id);

        this.marker.openPopup();

        return this;
    }

    showMarkerListTable(id) {
        if (!this.listTable) {
            return;
        }

        this.listTable
            .querySelectorAll('tr.selected')
            .forEach(tr => tr.classList.remove('selected'));

        const mapPoint = this.listTable.querySelector('[data-map-point="' + id + '"');

        if (!mapPoint) {
            return;
        }

        mapPoint.closest('tr').classList.add('selected');

        return this;
    }

    setView(point, zoom) {
        this.setZoom(zoom)
        this.getMap().setView(this.getLatLng(point), zoom);

        return this;
    }

    flyTo(point) {
        this.getMap().flyTo(this.getLatLng(point));

        return this;
    }

    fitBounds(options) {
        this.getMap().fitBounds(this.getLayer().getBounds(), this.getFitBoundsOptions(options));
        this.invalidateSize();
    }

    getFitBoundsOptions(options) {
        const defaults = {
            animate: false,
            padding: [40, 40]
        };

        return this.merge(defaults, options);
    }

    invalidateSize() {
        this.getMap().invalidateSize();
    }

    merge(first, second) {
        return JSON.parse(JSON.stringify(Object.assign({}, first || {}, second || {})));
    }

    getLatLng(points) {
        if (Array.isArray(points)) {
            return points.map((point) => this.getLatLng(point));
        }

        return {
            lat: points.latitude,
            lng: points.longitude
        };
    }

    getPointByLatitudeLongitude(latitude, longitude) {
        for (let i = 0; i < this.points.length; i++) {
            const point = this.points[i];

            if ((point.latitude === latitude) && (point.longitude === longitude)) {
                return point;
            }
        }
    }

    setListTable(listTable) {
        this.listTable = listTable;

        return this;
    }

    popupHtml(marker) {
        return ''
            + this.popupHtmlLine('clock', marker.date_at)
            + this.popupHtmlLine('location', '<a href="https://maps.google.com/?q=' + marker.latitude + ',' + marker.longitude + '" rel="nofollow noopener noreferrer" target="_blank">' + marker.latitude + ',' + marker.longitude + '</a>')
            + this.popupHtmlLine('speed', marker.speed_human)
            + this.popupHtmlLine('world', marker.city + ' (' + marker.state + ')');
    }

    popupHtmlLine(type, value) {
        return '<p style="margin: 0 !important; padding: 3px 20px 3px 0 !important; white-space: nowrap; vertical-align: middle !important;"><span style="margin-right: 5px">' + this.svg(type) + '</span> ' + value + '</p>';
    }

    array(array) {
        return Array.isArray(array) ? array : [];
    }

    svg(name) {
        return '<img src="' + WWW + '/build/images/map-popup-' + name + '.svg" width="15" height="15" style="display: inline-block;" />';
    }
};
