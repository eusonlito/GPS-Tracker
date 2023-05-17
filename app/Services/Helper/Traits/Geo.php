<?php declare(strict_types=1);

namespace App\Services\Helper\Traits;

use DateTimeZone;
use Exception;
use stdClass;

trait Geo
{
    /**
     * @param float $lat1
     * @param float $lng1
     * @param float $lat2
     * @param float $lng2
     *
     * @return int
     */
    public function coordinatesDistance(float $lat1, float $lng1, float $lat2, float $lng2): int
    {
        static $x = M_PI / 180;

        $lat1 *= $x;
        $lng1 *= $x;
        $lat2 *= $x;
        $lng2 *= $x;

        $distance = 2 * asin(sqrt(pow(sin(($lat1 - $lat2) / 2), 2) + cos($lat1) * cos($lat2) * pow(sin(($lng1 - $lng2) / 2), 2)));

        return intval($distance * 6378137);
    }

    /**
     * @param float $latitude
     * @param float $longitude
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
     * @param array $geojson
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
     * @return bool
     */
    public function latitudeLongitudeInsideGeoJson(float $latitude, float $longitude, array $geojson): bool
    {
        $polygon = $geojson['features'][0]['geometry']['coordinates'] ?? null;

        if (empty($polygon)) {
            return false;
        }

        if ($this->latitudeLongitudeInGeoJsonBoundingBox($latitude, $longitude, $geojson) === false) {
            return false;
        }

        $i = 0;
        $ii = 0;
        $k = 0;
        $f = 0;
        $u1 = 0;
        $v1 = 0;
        $u2 = 0;
        $v2 = 0;
        $currentP = null;
        $nextP = null;

        $numContours = count($polygon);

        for ($i = 0; $i < $numContours; $i++) {
            $ii = 0;
            $contourLen = count($polygon[$i]) - 1;
            $contour = $polygon[$i];

            $currentP = $contour[0];

            if ($currentP[0] !== $contour[$contourLen][0] && $currentP[1] !== $contour[$contourLen][1]) {
                throw new Exception('First and last coordinates in a ring must be the same');
            }

            $u1 = $currentP[0] - $longitude;
            $v1 = $currentP[1] - $latitude;

            for ($ii = 0; $ii < $contourLen; $ii++) {
                $nextP = $contour[$ii + 1];

                $v2 = $nextP[1] - $latitude;

                if (($v1 < 0 && $v2 < 0) || ($v1 > 0 && $v2 > 0)) {
                    $currentP = $nextP;
                    $v1 = $v2;
                    $u1 = $currentP[0] - $longitude;

                    continue;
                }

                $u2 = $nextP[0] - $longitude;

                if ($v2 > 0 && $v1 <= 0) {
                    $f = ($u1 * $v2) - ($u2 * $v1);

                    if ($f > 0) {
                        $k = $k + 1;
                    } elseif ($f === 0) {
                        return 0;
                    }
                } elseif ($v1 > 0 && $v2 <= 0) {
                    $f = ($u1 * $v2) - ($u2 * $v1);

                    if ($f < 0) {
                        $k = $k + 1;
                    } elseif ($f === 0) {
                        return 0;
                    }
                } elseif ($v2 === 0 && $v1 < 0) {
                    $f = ($u1 * $v2) - ($u2 * $v1);

                    if ($f === 0) {
                        return 0;
                    }
                } elseif ($v1 === 0 && $v2 < 0) {
                    $f = $u1 * $v2 - $u2 * $v1;

                    if ($f === 0) {
                        return 0;
                    }
                } elseif ($v1 === 0 && $v2 === 0) {
                    if ($u2 <= 0 && $u1 >= 0) {
                        return 0;
                    } elseif ($u1 <= 0 && $u2 >= 0) {
                        return 0;
                    }
                }

                $currentP = $nextP;
                $v1 = $v2;
                $u1 = $u2;
            }
        }

        return ($k % 2) !== 0;
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
