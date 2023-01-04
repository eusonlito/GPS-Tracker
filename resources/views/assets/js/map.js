import L from 'leaflet';
import 'leaflet-arrowheads';
import GeometryUtil from 'leaflet-geometryutil';

L.GeometryUtil = GeometryUtil;

import leafletPolycolor from 'leaflet-polycolor';

leafletPolycolor(L);

import Ajax from './ajax';
import Feather from './feather';
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

        this.point = [];

        this.speeds = [];

        this.icons = {};

        this.alarms = [];

        this.notifications = [];

        this.marker = null;
        this.markers = {};

        return this;
    }

    setMap() {
        this.map = L.map(this.getElement(), this.getMapOptions());

        this.setLayers();
        this.setLayerDefault();

        return this;
    }

    getMap() {
        if (!this.map) {
            this.setMap();
        }

        return this.map;
    }

    setLayers() {
        L.control.layers({ ...this.getLayers() }, null, { collapsed: true }).addTo(this.getMap());

        return this;
    }

    getLayers() {
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
            })
        };
    }

    setLayerDefault() {
        this.getLayers().OpenStreetMap.addTo(this.getMap());

        return this;
    }

    setLayer() {
        this.layer = new L.FeatureGroup()

        this.layer.addTo(this.getMap());

        return this;
    }

    getLayer() {
        if (!this.layer) {
            this.setLayer();
        }

        return this.layer;
    }

    setElement(element) {
        this.element = element;

        return this;
    }

    getElement() {
        return this.element;
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

    setPoints(points) {
        this.points = this.array(points).filter(this.isValidPoint);

        this.setSpeeds();
        this.setLinePoints(this.points);

        return this;
    }

    getPoints() {
        return this.points;
    }

    setPoint(point) {
        if (!this.isValidPoint(point)) {
            return this;
        }

        this.getPoints().push(point);
        this.setSpeeds();

        this.setLine();
        this.setLinePoints(this.getPoints());

        return this;
    }

    isValidPoint(point) {
        return point && point.id && point.latitude && point.longitude;
    }

    setSpeeds(speeds) {
        this.speeds =  this.getPoints().map(point => point.speed);

        const speedMin = Math.min(...this.speeds);
        const speedMax = Math.max(...this.speeds);

        this.setColors(this.speeds.map(speed => value2color(speed, speedMin, speedMax)));

        return this;
    }

    getSpeeds() {
        return this.speeds;
    }

    setColors(colors) {
        this.colors = this.array(colors);

        return this;
    }

    getColors() {
        return this.colors;
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

        L.circle(this.getLatLng(alarm.config), this.getAlarmOptions(alarm, options)).addTo(this.getMap());

        return this;
    }

    isValidAlarm(alarm) {
        return alarm && alarm.type && alarm.id && alarm.config
            && alarm.config.latitude && alarm.config.longitude && alarm.config.radius
            && ['fence-in', 'fence-out'].includes(alarm.type)
            && this.isValidAlarmNotLoaded(alarm);
    }

    isValidAlarmNotLoaded(alarm) {
        for (const i = 0; i < this.alarms.length; i++) {
            if (this.isSameAlarm(this.alarms[i], alarm)) {
                return false;
            }
        }

        return true;
    }

    isSameAlarm(loaded, current) {
        return (loaded.type === current.type)
            && (loaded.config.latitude === current.config.latitude)
            && (loaded.config.longitude === current.config.longitude)
            && (loaded.config.radius === current.config.radius);
    }

    getAlarmOptions(alarm, options) {
        const defaults = {
            radius: parseFloat(alarm.config.radius) * 1000,
            fillOpacity: 0.05,
            opacity: 0.3,
            color: (alarm.type === 'fence-in') ? 'red' : 'green',
            fillColor: (alarm.type === 'fence-in') ? 'red' : 'green',
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

        new L.Marker(this.getLatLng(notification), this.getNotificationOptions(notification, options)).addTo(this.getMap());

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

    setIcon (name, point, options) {
        if (this.icons[name]) {
            this.getMap().removeLayer(this.icons[name]);
        }

        this.icons[name] = new L.Marker(this.getLatLng(point), this.getIconOptions(name, options)).addTo(this.getMap());

        return this;
    }

    getIconOptions (name, options) {
        const defaults = {
            iconUrl: WWW + '/build/images/map-' + name + '.svg',
            iconSize: [30, 42],
            iconAnchor: [15, 42],
        };

        return { icon: L.icon(this.merge(defaults, options)) };
    }

    setLine(lineOptions, arrowOptions) {
        this.line = L.polycolor([], this.getLineOptions(lineOptions))
            .arrowheads(this.getArrowOptions(arrowOptions))
            .addTo(this.getLayer());

        return this;
    }

    getLineOptions(options) {
        const defaults = {
            colors: this.getColors(),
            useGradient: true,
            weight: 5,
            opacity: 1,
            smoothFactor: 2
        };

        return this.merge(defaults, options);
    }

    getArrowOptions(options) {
        const defaults = {
            yawn: 40,
            size: '5px',
            fill: true,
            fillOpacity: 0.7,
            opacity: 0.7
        };

        return this.merge(defaults, options);
    }

    setLinePoints(points) {
        this.getLine().setLatLngs(this.getLatLng(points));

        return this;
    }

    getLine() {
        if (!this.line) {
            this.setLine();
        }

        return this.line;
    }

    setMarkers(markers, options) {
        this.array(markers).forEach(marker => this.setMarker(marker, options));

        return this;
    }

    setMarker(marker, options) {
        if (!this.isValidMarker(marker)) {
            return this;
        }

        this.markers[marker.id] = L.circleMarker(this.getLatLng(marker), this.getMarkerOptions(marker, options))
            .bindPopup(this.jsonToHtml(marker))
            .addTo(this.getLayer());

        return this;
    }

    isValidMarker(marker) {
        return marker && marker.id && marker.latitude && marker.longitude;
    }

    getMarkerOptions(options) {
        const defaults = {
            radius: 20,
            fillOpacity: 0,
            opacity: 0,
        };

        return this.merge(defaults, options);
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

        this.marker.openPopup();

        return this;
    }

    setView(point, zoom) {
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
            padding: [30, 30]
        };

        return this.merge(defaults, options);
    }

    invalidateSize() {
        this.getMap().invalidateSize();
    }

    render() {
    }

    merge(first, second) {
        return JSON.parse(JSON.stringify(Object.assign({}, first || {}, second || {})));
    }

    getLatLng(points) {
        if (Array.isArray(points)) {
            return points.map(this.getLatLng);
        }

        return {
            lat: points.latitude,
            lng: points.longitude
        };
    }

    jsonToHtml(json) {
        return Object.keys(json).map(key => this.jsonToHtmlKeyValue(key, json[key])).join('');
    }

    jsonToHtmlKeyValue(key, value) {
        return '<p style="margin: 0.5em 0 !important"><strong>' + this.ucfirst(key.replace(/_at$/, '')) + ':</strong> ' + value + '</p>';
    }

    ucfirst(string) {
        return string[0].toUpperCase() + string.slice(1);
    }

    array(array) {
        return Array.isArray(array) ? array : [];
    }
};
