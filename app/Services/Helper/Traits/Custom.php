<?php declare(strict_types=1);

namespace App\Services\Helper\Traits;

use DateTimeZone;
use stdClass;

trait Custom
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
