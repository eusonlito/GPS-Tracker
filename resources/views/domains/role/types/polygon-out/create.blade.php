<textarea name="config[geojson]" class="hidden" id="alarm-type-polygon-geojson" required>@json($REQUEST->input('config.geojson'))</textarea>

<div class="map-polygon mt-5" data-map-polygon data-map-polygon-latitude="{{ $position?->latitude }}" data-map-polygon-longitude="{{ $position?->longitude }}" data-map-polygon-input="#alarm-type-polygon-geojson"></div>
