<?php declare(strict_types=1);

namespace App\Services\Helper\Traits;

use DateTimeZone;
use stdClass;

trait Geo
{
    /**
     * @param float $latitude
     *
     * @return float
     */
    public function latitude(float $latitude): float
    {
        return max(-89.99999, min(89.99999, $latitude));
    }

    /**
     * @param float $longitude
     *
     * @return float
     */
    public function longitude(float $longitude): float
    {
        return max(-179.99999, min(179.99999, $longitude));
    }

    /**
     * @param float $lat1
     * @param float $lng1
     * @param float $lat2
     * @param float $lng2
     *
     * @return float
     */
    public function coordinatesDistance(float $lat1, float $lng1, float $lat2, float $lng2): float
    {
        static $x = M_PI / 180;

        $lat1 *= $x;
        $lng1 *= $x;
        $lat2 *= $x;
        $lng2 *= $x;

        $distance = 2 * asin(sqrt(pow(sin(($lat1 - $lat2) / 2), 2) + cos($lat1) * cos($lat2) * pow(sin(($lng1 - $lng2) / 2), 2)));

        return $distance * 6378137;
    }

    /**
     * @param float $lat1
     * @param float $lng1
     * @param float $lat2
     * @param float $lng2
     *
     * @return int
     */
    public function coordinatesDirection(float $lat1, float $lng1, float $lat2, float $lng2): int
    {
        static $x = M_PI / 180;

        $lat1 *= $x;
        $lng1 *= $x;
        $lat2 *= $x;
        $lng2 *= $x;

        $delta = $lng2 - $lng1;

        $y = sin($delta) * cos($lat2);
        $x = cos($lat1) * sin($lat2) - sin($lat1) * cos($lat2) * cos($delta);

        return round(rad2deg(atan2($y, $x)) + 360) % 360;
    }

    /**
     * @param array $geojson
     *
     * @return array
     */
    public function geoJsonBoundingBox(array $geojson): array
    {
        $polygon = $geojson['features'][0]['geometry']['coordinates'] ?? null;

        if (empty($polygon)) {
            return [[0, 0], [0, 0]];
        }

        $minLat = INF;
        $maxLat = -INF;
        $minLng = INF;
        $maxLng = -INF;

        foreach ($polygon as $contour) {
            foreach ($contour as $coordinates) {
                $lng = $coordinates[0];
                $lat = $coordinates[1];

                $minLat = min($minLat, $lat);
                $maxLat = max($maxLat, $lat);
                $minLng = min($minLng, $lng);
                $maxLng = max($maxLng, $lng);
            }
        }

        return [[$minLng, $minLat], [$maxLng, $maxLat]];
    }

    /**
     * @param float $latitude
     * @param float $longitude
     * @param array $bbox
     *
     * @return bool
     */
    public function latitudeLongitudeInBoundingBox(float $latitude, float $longitude, array $bbox): bool
    {
        return ($bbox[0][0] <= $longitude)
            && ($bbox[0][1] <= $latitude)
            && ($bbox[1][0] >= $longitude)
            && ($bbox[1][1] >= $latitude);
    }

    /**
     * @param float $latitude
     * @param float $longitude
     * @param array $geojson
     *
     * @return bool
     */
    public function latitudeLongitudeInGeoJsonBoundingBox(float $latitude, float $longitude, array $geojson): bool
    {
        return $this->latitudeLongitudeInBoundingBox($latitude, $longitude, $this->geoJsonBoundingBox($geojson));
    }

    /**
     * @param float $latitude
     * @param float $longitude
     * @param array $geojson
     *
     * @return ?bool
     */
    public function latitudeLongitudeInsideGeoJson(float $latitude, float $longitude, array $geojson): ?bool
    {
        $coordinates = $geojson['features'][0]['geometry']['coordinates'][0] ?? null;

        if (empty($coordinates)) {
            return null;
        }

        if ($this->latitudeLongitudeInGeoJsonBoundingBox($latitude, $longitude, $geojson) === false) {
            return false;
        }

        $inside = false;
        $n = count($coordinates);

        for ($i = 0, $j = $n - 1; $i < $n; $j = $i++) {
            $xi = $coordinates[$i][0];
            $yi = $coordinates[$i][1];
            $xj = $coordinates[$j][0];
            $yj = $coordinates[$j][1];

            if ((($yi > $latitude) !== ($yj > $latitude)) && ($longitude < ($xj - $xi) * ($latitude - $yi) / ($yj - $yi) + $xi)) {
                $inside = $inside === false;
            }
        }

        return $inside;
    }

    /**
     * @param float $latitude
     * @param float $longitude
     * @param ?string $country = null
     *
     * @return string
     */
    public function latitudeLongitudeTimezone(float $latitude, float $longitude, ?string $country = null): string
    {
        $timezones = $this->countryTimezones($country);

        if (count($timezones) === 1) {
            return $timezones[0];
        }

        $timezone = null;
        $tz_distance = 0;

        foreach ($timezones as $id) {
            $location = timezone_location_get(new DateTimeZone($id));

            $distance = (sin(deg2rad($latitude)) * sin(deg2rad($location['latitude'])))
                + (cos(deg2rad($latitude)) * cos(deg2rad($location['latitude'])) * cos(deg2rad($longitude - $location['longitude'])));

            $distance = abs(rad2deg(acos($distance)));

            if ($timezone && ($tz_distance < $distance)) {
                continue;
            }

            $timezone = $id;
            $tz_distance = $distance;
        }

        return $timezone;
    }

    /**
     * @param int $mcc
     * @param int $mnc
     *
     * @return ?\stdClass
     */
    public function mcc(int $mcc, int $mnc): ?stdClass
    {
        static $cache = [];

        if (isset($cache[$mcc][$mnc])) {
            return $cache[$mcc][$mnc];
        }

        $country = [];

        foreach ($this->mccs() as $each) {
            if ($each->mcc !== $mcc) {
                continue;
            }

            if ($each->mnc === $mnc) {
                return $cache[$mcc][$mnc] = $each;
            }

            $country[$each->iso][] = $each;
        }

        if (empty($country)) {
            return null;
        }

        usort($country, static fn ($a, $b) => count($a) > count($b) ? -1 : 1);

        return $cache[$mcc][$mnc] = $country[0][0];
    }

    /**
     * @return array
     */
    public function mccs(): array
    {
        static $cache;

        return $cache ??= json_decode(file_get_contents(base_path('resources/app/mcc/mcc.json')));
    }
}
