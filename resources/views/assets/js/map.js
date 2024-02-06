import L from 'leaflet';

import 'leaflet-rotatedmarker';

import GeometryUtil from 'leaflet-geometryutil';

L.GeometryUtil = GeometryUtil;

import leafletPolycolor from 'leaflet-polycolor';

leafletPolycolor(L);

import Ajax from './ajax';
import Storage from './storage';
import feather from './feather';
import value2color from './value2color';
import number2color from './number2color';

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
        this.layerDevices = null;
        this.layerVehicles = null;
        this.layerRefuels = null;
        this.layerTrips = null;

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

        this.trips = {};

        this.listTable = null;

        this.storage = new Storage('map');

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

    getLayerDevices() {
        if (!this.layerDevices) {
            this.setLayerDevices();
        }

        return this.layerDevices;
    }

    setLayerDevices() {
        this.layerDevices = new L.FeatureGroup();

        this.getLayer().addLayer(this.layerDevices);

        return this;
    }

    getLayerVehicles() {
        if (!this.layerVehicles) {
            this.setLayerVehicles();
        }

        return this.layerVehicles;
    }

    setLayerVehicles() {
        this.layerVehicles = new L.FeatureGroup();

        this.getLayer().addLayer(this.layerVehicles);

        return this;
    }

    getLayerRefuels() {
        if (!this.layerRefuels) {
            this.setLayerRefuels();
        }

        return this.layerRefuels;
    }

    setLayerRefuels() {
        this.layerRefuels = new L.FeatureGroup();

        this.getLayer().addLayer(this.layerRefuels);

        return this;
    }

    getLayerTrips() {
        if (!this.layerTrips) {
            this.setLayerTrips();
        }

        return this.layerTrips;
    }

    setLayerTrips() {
        this.layerTrips = new L.FeatureGroup();

        this.getLayer().addLayer(this.layerTrips);

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

    static getControlLayers() {
        return {
            OpenStreetMap: L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxNativeZoom: 19,
                maxZoom: 22
            }),
            GoogleStreets: L.tileLayer('https://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
                maxNativeZoom: 20,
                maxZoom: 22,
                subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
            }),
            GoogleSatellite: L.tileLayer('https://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}',{
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
        L.control.layers(this.constructor.getControlLayers(), null, { position: 'topright', collapsed: true })
            .addTo(this.getMap());

        this.getMap().on('baselayerchange', (e) => {
            this.storage.set('layer', e.name);
        });

        return this;
    }

    setControlLayerDefault() {
        const layers = this.constructor.getControlLayers();
        let name = this.storage.get('layer');

        if (!name || !layers[name]) {
            name = Object.keys(layers)[0];
        }

        layers[name].addTo(this.getMap());

        return this;
    }

    setControlMarkers() {
        if (this.getElement().dataset.mapControlMarkersDisabled !== undefined) {
            return;
        }

        this.setControlMarkersCreate();
        this.setControlMarkersLoad();
    }

    setControlMarkersCreate() {
        const container = this.setControlMarkersCreateContainer();

        L.Control.Markers = L.Control.extend({ onAdd: () => container });
        L.control.markers = (options) => new L.Control.Markers(options);

        if (this.storage.get('markers') === true) {
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

                this.storage.set('markers', false);
            } else {
                img.style.background = '#A3EA9A';

                layerMarkers.addTo(map);
                layerMarkers.bringToBack();

                this.storage.set('markers', true);
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

    setSpeeds() {
        this.speeds = this.getPoints().map(point => point.speed);

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

    setDevices(devices) {
        this.getLayer().removeLayer(this.getLayerDevices());
        this.setLayerDevices();

        this.array(devices).forEach((device) => this.setDevice(device));

        return this;
    }

    setDevice(device, options) {
        if (!this.isValidDevice(device)) {
            return this;
        }

        const id = device.id;
        const latLng = this.getLatLng(device.position);
        const html = this.devicePopupHtml(device);

        this.markers[id] = new L.Marker(latLng, this.getDeviceMarkerOptions(device, options))
            .bindPopup(html, this.getDevicePopupOptions(device))
            .bindTooltip(this.getDeviceTooltipTitle(device), this.getDeviceTooltipOptions(device))
            .on('click', (e) => this.showMarker(id))
            .addTo(this.getLayerDevices());

        return this;
    }

    getDeviceMarkerOptions(device, options) {
        return {
            opacity: 0,
            icon: L.divIcon(),
        };
    }

    getDevicePopupOptions(device) {
        return {
            offset: new L.Point(0, -25)
        };
    }

    getDeviceTooltipTitle(device) {
        let title = device.name;

        if (device.vehicle) {
            if (device.name !== device.vehicle.name) {
                title += '<br />' + device.vehicle.name;
            }

            if (device.vehicle.plate && device.vehicle.plate.length) {
                title += '<br />' + device.vehicle.plate;
            }
        }

        return title;
    }

    getDeviceTooltipOptions(device) {
        return {
            interactive: true,
            permanent: true,
            direction: 'top',
            className: 'map-device-label',
            opacity: 1,
        };
    }

    isValidDevice(device) {
        return device && device.id && device.name && this.isValidPoint(device.position);
    }

    setVehicles(vehicles) {
        this.getLayer().removeLayer(this.getLayerVehicles());
        this.setLayerVehicles();

        this.array(vehicles).forEach((vehicle) => this.setVehicle(vehicle));

        return this;
    }

    setVehicle(vehicle, options) {
        if (!this.isValidVehicle(vehicle)) {
            return this;
        }

        const id = vehicle.id;
        const latLng = this.getLatLng(vehicle.position);
        const html = this.vehiclePopupHtml(vehicle);

        this.markers[id] = new L.Marker(latLng, this.getVehicleMarkerOptions(vehicle, options))
            .bindPopup(html, this.getVehiclePopupOptions(vehicle))
            .bindTooltip(this.getVehicleTooltipTitle(vehicle), this.getVehicleTooltipOptions(vehicle))
            .on('click', (e) => this.showMarker(id))
            .addTo(this.getLayerVehicles());

        return this;
    }

    getVehicleMarkerOptions(vehicle, options) {
        return {
            opacity: 0,
            icon: L.divIcon(),
        };
    }

    getVehiclePopupOptions(vehicle) {
        return {
            offset: new L.Point(0, -25)
        };
    }

    getVehicleTooltipTitle(vehicle) {
        let title = vehicle.name;

        if (vehicle.plate && vehicle.plate.length) {
            title += '<br />' + vehicle.plate;
        }

        return title;
    }

    getVehicleTooltipOptions(vehicle) {
        return {
            interactive: true,
            permanent: true,
            direction: 'top',
            className: 'map-vehicle-label',
            opacity: 1,
        };
    }

    isValidVehicle(vehicle) {
        return vehicle && vehicle.id && vehicle.name && this.isValidPoint(vehicle.position);
    }

    setRefuels(refuels) {
        this.getLayer().removeLayer(this.getLayerRefuels());
        this.setLayerRefuels();

        this.array(refuels).forEach((refuel) => this.setRefuel(refuel));

        return this;
    }

    setRefuel(refuel, options) {
        if (!this.isValidRefuel(refuel)) {
            return this;
        }

        const id = refuel.id;
        const latLng = this.getLatLng(refuel);
        const html = this.refuelPopupHtml(refuel);

        this.markers[id] = new L.Marker(latLng, this.getRefuelMarkerOptions(refuel, options))
            .bindPopup(html, this.getRefuelBindPopupOptions(refuel))
            .bindTooltip(refuel.price, this.getRefuelTooltipOptions(refuel))
            .on('click', (e) => this.showMarker(id))
            .addTo(this.getLayerRefuels());

        return this;
    }

    getRefuelMarkerOptions(refuel, options) {
        return {
            opacity: 0,
            icon: L.divIcon(),
        };
    }

    getRefuelBindPopupOptions(refuel) {
        return {
            offset: new L.Point(0, -25)
        };
    }

    getRefuelTooltipOptions(refuel) {
        return {
            interactive: true,
            permanent: true,
            direction: 'top',
            className: 'map-refuel-label',
            opacity: 1,
        };
    }

    isValidRefuel(refuel) {
        return refuel && refuel.id && refuel.date_at && this.isValidPoint(refuel);
    }

    setTrips(trips) {
        this.setTripsReset();

        this.array(trips).forEach((trip) => this.setTrip(trip));

        return this;
    }

    setTripsReset() {
        const layer = this.getLayerTrips();

        Object.values(this.trips).forEach(trip => {
            if (!trip.layer) {
                return;
            }

            if (trip.line) {
                trip.layer.removeLayer(trip.line);
            }

            layer.removeLayer(trip.layer);
        });

        this.trips = {};

        return this;
    }

    setTrip(trip, options) {
        if (!this.isValidTrip(trip)) {
            return this;
        }

        const id = trip.id;

        if (!this.trips[id]) {
            this.trips[id] = trip;
        }

        this.setTripLayer(trip);

        this.setTripMarker(trip, trip.positions[0], { start: true });
        this.setTripMarker(trip, trip.positions[trip.positions.length - 1], { finish: true });
        this.setTripPositions(trip, trip.positions);
    }

    setTripLayer(trip) {
        if (trip.layer) {
            this.getLayerTrips().removeLayer(trip.layer);
        }

        trip.layer = new L.FeatureGroup();

        this.getLayerTrips().addLayer(trip.layer);

        return this;
    }

    setTripMarker(trip, position, options) {
        const latLng = this.getLatLng(position);
        const html = this.tripPopupHtml(trip);

        this.markers[position.id] = new L.Marker(latLng, this.getTripMarkerOptions(trip))
            .bindPopup(html, this.getTripBindPopupOptions(trip))
            .bindTooltip(this.getTripTooltipTitle(trip, options), this.getTripTooltipOptions(trip, options))
            .on('click', (e) => this.setTripMarkerClick(trip, position))
            .addTo(trip.layer);

        return this;
    }

    getTripMarkerOptions(trip) {
        return {
            opacity: 0,
            icon: L.divIcon(),
        };
    }

    getTripBindPopupOptions(trip) {
        return {
            offset: new L.Point(0, -25)
        };
    }

    getTripTooltipTitle(trip, options) {
        let title = '';

        if (options.start) {
            title += trip.start_at;
        } else if (options.finish) {
            title += trip.end_at;
        }

        if (trip.device?.name) {
            title += '<br />' + trip.device.name;
        }

        if (trip.vehicle?.name) {
            title += '<br />' + trip.vehicle.name;
        }

        if (trip.vehicle?.plate) {
            title += '<br />' + trip.vehicle.plate;
        }

        return title;
    }

    getTripTooltipOptions(trip, options) {
        return {
            interactive: true,
            permanent: true,
            direction: 'top',
            className: this.getTripTooltipOptionsClassName(trip, options),
            opacity: 0.8,
        };
    }

    getTripTooltipOptionsClassName(trip, options) {
        let className = 'map-trip-label';

        if (!options) {
            return className;
        }

        if (options.start) {
            className += ' map-trip-label-start';
        } else if (options.finish) {
            className += ' map-trip-label-finish';
        }

        return className;
    }

    setTripPositions(trip, positions) {
        if (trip.line) {
            trip.layer.removeLayer(trip.line);
        }

        trip.line = new L.Polyline(positions.map(this.getLatLng), this.setTripPositionsOptions(trip))
            .on('click', (e) => this.setTripPositionsClick(trip))
            .addTo(trip.layer);

        return this;
    }

    setTripPositionsOptions(trip) {
        return {
            color: number2color(trip.id),
            weight: 5,
            opacity: 0.8,
            smoothFactor: 1,
        };
    }

    setTripMarkerClick(trip, position) {
        if (this.marker) {
            this.setTripMarkerClickClose(trip, position);
        } else {
            this.setTripMarkerClickOpen(trip, position);
        }

        return this;
    }

    setTripMarkerClickOpen(trip, position) {
        this.marker = this.markers[position.id];

        return this;
    }

    setTripMarkerClickClose(trip) {
        if (this.marker) {
            this.marker.closePopup();
        }

        this.marker = null;

        return this;
    }

    setTripPositionsClick(trip) {
        const layers = this.getLayerTrips().getLayers();
        let current;

        if ((layers.length === 1) && (this.trips[trip.id]?.layer === layers[0])) {
            current = this.trips[trip.id];
        }

        if (current && (current.id === trip.id)) {
            this.setTripPositionsClickClose(trip);
        } else {
            this.setTripPositionsClickOpen(trip);
        }

        this.fitBounds();

        return this;
    }

    setTripPositionsClickOpen(trip) {
        const layer = this.getLayerTrips();

        Object.values(this.trips).map(current => {
            if (current.id === trip.id) {
                if (!layer.hasLayer(current.layer)) {
                    layer.addLayer(current.layer);
                }
            } else {
                layer.removeLayer(current.layer);
            }
        });

        return this;
    }

    setTripPositionsClickClose(trip) {
        this.setTrips(Object.values(this.trips));

        return this;
    }

    isValidTrip(trip) {
        return trip && trip.id && trip.name && trip.positions && trip.positions.length;
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
        const html = this.popupHtmlPosition(marker);

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
        if (!points) {
            return null;
        }

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

    devicePopupHtml(device) {
        let html = this.popupHtmlLine('device', device.name);

        if (device.vehicle) {
            if (device.name !== device.vehicle.name) {
                html += this.popupHtmlLine('vehicle', device.vehicle.name);
            }

            if (device.vehicle.plate && device.vehicle.plate.length) {
                html += this.popupHtmlLine('plate', device.vehicle.plate);
            }
        }

        return html + this.popupHtmlPosition(device.position);
    }

    vehiclePopupHtml(vehicle) {
        let html = this.popupHtmlLine('vehicle', vehicle.name);

        if (vehicle.plate && vehicle.plate.length) {
            html += this.popupHtmlLine('plate', vehicle.plate);
        }

        return html + this.popupHtmlPosition(vehicle.position);
    }

    refuelPopupHtml(refuel) {
        return this.popupHtmlLine('vehicle', refuel.vehicle.name)
            + this.popupHtmlLine('clock', refuel.date_at)
            + this.popupHtmlLine('location', '<a href="https://maps.google.com/?q=' + refuel.latitude + ',' + refuel.longitude + '" rel="nofollow noopener noreferrer" target="_blank">' + refuel.latitude + ',' + refuel.longitude + '</a>')
            + this.popupHtmlLineLocation(refuel);
    }

    popupHtmlPosition(marker) {
        return this.popupHtmlLine('clock', marker.date_at)
            + this.popupHtmlLine('location', '<a href="https://maps.google.com/?q=' + marker.latitude + ',' + marker.longitude + '" rel="nofollow noopener noreferrer" target="_blank">' + marker.latitude + ',' + marker.longitude + '</a>')
            + this.popupHtmlLine('speed', marker.speed_human)
            + this.popupHtmlLineLocation(marker);
    }

    tripPopupHtml(trip) {
        return this.popupHtmlLine('trip', trip.name)
            + this.popupHtmlLine('vehicle', trip.vehicle?.name)
            + this.popupHtmlLine('device', trip.device?.name)
            + this.popupHtmlLine('distance', trip.distance_human)
            + this.popupHtmlLine('clock', trip.time_human);
    }

    popupHtmlLine(type, value) {
        if (!value || !value.length) {
            return '';
        }

        return '<p style="margin: 0 !important; padding: 3px 20px 3px 0 !important; white-space: nowrap; vertical-align: middle !important;">' + this.svg(type) + ' ' + value + '</p>';
    }

    popupHtmlLineLocation(marker) {
        if (!marker.city || !marker.state) {
            return '';
        }

        return this.popupHtmlLine('world', marker.city + ' (' + marker.state + ')');
    }

    array(array) {
        return Array.isArray(array) ? array : [];
    }

    svg(name) {
        return '<span style="margin-right: 5px"><img src="' + WWW + '/build/images/map-popup-' + name + '.svg" width="15" height="15" style="display: inline-block;" /></span>';
    }
};
