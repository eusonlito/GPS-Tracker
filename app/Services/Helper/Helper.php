<?php declare(strict_types=1);

namespace App\Services\Helper;

use DateTime;
use DateTimeZone;
use Error;
use ErrorException;
use Exception;
use LogicException;
use RecursiveArrayIterator;
use RecursiveIteratorIterator;
use RuntimeException;
use stdClass;
use Stringable;
use Throwable;
use App\Exceptions\NotFoundException;

class Helper
{
    /**
     * @param string $dir
     * @param bool $file = false
     *
     * @return string
     */
    public function mkdir(string $dir, bool $file = false): string
    {
        if ($file) {
            $dir = dirname($dir);
        }

        clearstatcache(true, $dir);

        if (is_dir($dir)) {
            return $dir;
        }

        try {
            mkdir($dir, 0o755, true);
        } catch (Exception $e) {
        }

        return $dir;
    }

    /**
     * @param string $file
     * @param string $contents
     *
     * @return void
     */
    public function filePutContents(string $file, string $contents): void
    {
        $this->mkdir($file, true);

        file_put_contents($file, $contents, LOCK_EX);
    }

    /**
     * @return string
     */
    public function uuid(): string
    {
        $data = random_bytes(16);

        $data[6] = chr(ord($data[6]) & 0x0F | 0x40);
        $data[8] = chr(ord($data[8]) & 0x3F | 0x80);

        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }

    /**
     * @param int $length
     * @param bool $safe = false
     * @param bool $lower = false
     *
     * @return string
     */
    public function uniqidReal(int $length, bool $safe = false, bool $lower = false): string
    {
        if ($safe) {
            $string = '23456789bcdfghjkmnpqrstwxyzBCDFGHJKMNPQRSTWXYZ';
        } else {
            $string = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        }

        if ($lower) {
            $string = strtolower($string);
        }

        return substr(str_shuffle(str_repeat($string, rand((int)($length / 2), $length))), 0, $length);
    }

    /**
     * @param mixed $value
     *
     * @return ?string
     */
    public function jsonEncode($value): ?string
    {
        if ($value === null) {
            return null;
        }

        return json_encode($value, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PARTIAL_OUTPUT_ON_ERROR);
    }

    /**
     * @param string $key
     *
     * @return string
     */
    public function arrayKeyDot(string $key): string
    {
        return rtrim(str_replace(['][', '[', ']'], ['.', '.', ''], $key), '.');
    }

    /**
     * @param array $array
     * @param array $keys
     *
     * @return array
     */
    public function arrayKeysWhitelist(array $array, array $keys): array
    {
        return array_intersect_key($array, array_flip($keys));
    }

    /**
     * @param array $array
     * @param array $keys
     *
     * @return array
     */
    public function arrayKeysBlacklist(array $array, array $keys): array
    {
        return array_diff_key($array, array_flip($keys));
    }

    /**
     * @param array $array
     * @param array $values
     *
     * @return array
     */
    public function arrayValuesWhitelist(array $array, array $values): array
    {
        return array_intersect($array, $values);
    }

    /**
     * @param array $array
     * @param array $values
     *
     * @return array
     */
    public function arrayValuesBlacklist(array $array, array $values): array
    {
        return array_diff($array, $values);
    }

    /**
     * @param array $array
     * @param ?callable $callback = null
     *
     * @return array
     */
    public function arrayFilterRecursive(array $array, ?callable $callback = null): array
    {
        $callback ??= static fn ($value) => (bool)$value;

        return array_filter(array_map(fn ($value) => is_array($value) ? $this->arrayFilterRecursive($value, $callback) : $value, $array), $callback);
    }

    /**
     * @param array $array
     * @param callable $callback
     * @param bool $values_only = true
     *
     * @return array
     */
    public function arrayMapRecursive(array $array, callable $callback, bool $values_only = true): array
    {
        $keys = array_keys($array);

        $map = function ($value, $key) use ($callback, $values_only) {
            if (is_array($value) === false) {
                return $callback($value, $key);
            }

            if ($values_only) {
                return $this->arrayMapRecursive($value, $callback, $values_only);
            }

            return $this->arrayMapRecursive($callback($value, $key), $callback, $values_only);
        };

        return array_combine($keys, array_map($map, $array, $keys));
    }

    /**
     * @param array $array
     *
     * @return array
     */
    public function arrayFlatten(array $array): array
    {
        return iterator_to_array(new RecursiveIteratorIterator(new RecursiveArrayIterator($array)), true);
    }

    /**
     * @param array $array
     * @param array $exclude = []
     * @param array $include = []
     *
     * @return array
     */
    public function arrayValuesRecursive(array $array, array $exclude = [], array $include = []): array
    {
        $result = [];

        foreach ($array as $key => $value) {
            if ($exclude && in_array($key, $exclude)) {
                continue;
            }

            if (is_array($value)) {
                $result = array_merge($result, $this->arrayValuesRecursive($value, $exclude, $include));
            } elseif (empty($include) || in_array($key, $include)) {
                $result[] = $value;
            }
        }

        return $result;
    }

    /**
     * @param array $array
     *
     * @return bool
     */
    public function arrayIsAssociative(array $array): bool
    {
        return ($keys = array_keys($array)) !== array_keys($keys);
    }

    /**
     * @param array $array
     *
     * @return string
     */
    public function arrayHtmlAttributes(array $array): string
    {
        return implode(' ', array_filter(array_map(function ($key, $value) {
            if (is_bool($value)) {
                return $key;
            }

            if (is_string($value) || ($value instanceof Stringable)) {
                return $key.'='.htmlentities((string)$value);
            }

            return '';
        }, array_keys($array), $array)));
    }

    /**
     * @param ?float $value
     * @param int $decimals = 2
     * @param ?string $default = '-'
     *
     * @return ?string
     */
    public function number(?float $value, int $decimals = 2, ?string $default = '-'): ?string
    {
        if ($value === null) {
            return $default;
        }

        return number_format($value, $decimals, ',', '.');
    }

    /**
     * @param ?float $value
     * @param int $decimals = 2
     *
     * @return ?string
     */
    public function money(?float $value, int $decimals = 2): ?string
    {
        return $this->number($value, $decimals).'€';
    }

    /**
     * @param int $bytes
     * @param int $decimals = 2
     *
     * @return string
     */
    public function sizeHuman(int $bytes, int $decimals = 2): string
    {
        if ($bytes === 0) {
            return '0B';
        }

        $e = floor(log($bytes, 1024));

        return round($bytes / pow(1024, $e), $decimals).['B', 'KB', 'MB', 'GB', 'TB', 'PB'][$e];
    }

    /**
     * @param int $meters
     * @param int $decimals = 2
     *
     * @return string
     */
    public function distanceHuman(int $meters, int $decimals = 2): string
    {
        return $this->number(($km = ($meters >= 1000)) ? ($meters / 1000) : $meters, $decimals).' '.($km ? 'km' : 'm');
    }

    /**
     * @param int $seconds
     *
     * @return string
     */
    public function timeHuman(int $seconds): string
    {
        return sprintf('%02d:%02d:%02d', floor($seconds / 3600), floor($seconds / 60 % 60), floor($seconds % 60));
    }

    /**
     * @param ?string $date
     * @param ?string $default = '-'
     *
     * @return string
     */
    public function dateLocal(?string $date, ?string $default = '-'): ?string
    {
        if (empty($date)) {
            return $default;
        }

        $time = strtotime($date);

        if ($time === false) {
            return $default;
        }

        return date(str_contains($date, ' ') ? 'd/m/Y H:i' : 'd/m/Y', $time);
    }

    /**
     * @param string $date
     * @param ?string $default = null
     *
     * @return ?string
     */
    public function dateToDate(string $date, ?string $default = null): ?string
    {
        if (empty($date)) {
            return $default;
        }

        [$day, $time] = explode(' ', $date) + ['', ''];

        if (str_contains($day, ':')) {
            [$day, $time] = [$time, $day];
        }

        if (!preg_match('#^[0-9]{1,4}[/\-][0-9]{1,2}[/\-][0-9]{1,4}$#', $day)) {
            return $default;
        }

        if ($time) {
            if (substr_count($time, ':') === 1) {
                $time .= ':00';
            }

            if (!preg_match('#^[0-9]{1,2}:[0-9]{1,2}:[0-9]{1,2}$#', $time)) {
                return $default;
            }
        }

        $day = preg_split('#[/\-]#', $day);

        if (strlen($day[0]) !== 4) {
            $day = array_reverse($day);
        }

        return trim(implode('-', $day).' '.$time);
    }

    /**
     * @param string $format_from
     * @param string $date
     * @param string $timezone
     * @param string $format_to = 'Y-m-d H:i:s'
     *
     * @return string
     */
    public function dateUtcToTimezone(string $format_from, string $date, string $timezone, string $format_to = 'Y-m-d H:i:s'): string
    {
        return $this->dateToTimezone($format_from, $date, 'UTC', $timezone, $format_to);
    }

    /**
     * @param string $format_from
     * @param string $date
     * @param string $timezone
     * @param string $format_to = 'Y-m-d H:i:s'
     *
     * @return string
     */
    public function dateTimezoneToUtc(string $format_from, string $date, string $timezone, string $format_to = 'Y-m-d H:i:s'): string
    {
        return $this->dateToTimezone($format_from, $date, $timezone, 'UTC', $format_to);
    }

    /**
     * @param string $format_from
     * @param string $date
     * @param string $timezone_from
     * @param string $timezone_to
     * @param string $format_to = 'c'
     *
     * @return string
     */
    public function dateToTimezone(
        string $format_from,
        string $date,
        string $timezone_from,
        string $timezone_to,
        string $format_to = 'c'
    ): string {
        if ((substr_count($date, ':') === 1) && (substr_count($format_from, ':') === 2)) {
            $date .= ':00';
        }

        if (str_starts_with($format_from, 'Y') && preg_match('/^[0-9]{2}[\/\-]/', $date)) {
            $date = $this->dateToDate($date);
        }

        if (str_contains($date, '+') && (str_contains($format_from, '+') === false)) {
            $format_from .= 'O';
        }

        $timezone = $this->dateTimeZone($timezone_from);
        $datetime = DateTime::createFromFormat($format_from, $date, $timezone);

        try {
            $datetime = $datetime ?: new DateTime($date, $timezone);
        } catch (Exception $e) {
            $datetime = $datetime ?: new DateTime('now', $timezone);
        }

        return $datetime->setTimezone($this->dateTimeZone($timezone_to))->format($format_to);
    }

    /**
     * @param string $timezone
     *
     * @return \DateTimeZone
     */
    public function dateTimeZone(string $timezone): DateTimeZone
    {
        static $cache;

        return $cache[$timezone] ??= new DateTimeZone($timezone);
    }

    /**
     * @param float $lat1
     * @param float $lng1
     * @param float $lat2
     * @param float $lng2
     *
     * @return int
     */
    public function coordinatesDistance(float $lat1, float $lng1, float $lat2, float $lng2, int $radius = 6378137): int
    {
        static $x = M_PI / 180;

        $lat1 *= $x;
        $lng1 *= $x;
        $lat2 *= $x;
        $lng2 *= $x;

        $distance = 2 * asin(sqrt(pow(sin(($lat1 - $lat2) / 2), 2) + cos($lat1) * cos($lat2) * pow(sin(($lng1 - $lng2) / 2), 2)));

        return intval($distance * $radius);
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
     * @param ?string $country
     *
     * @return array
     */
    public function countryTimezones(?string $country): array
    {
        if ($country === null) {
            return DateTimeZone::listIdentifiers();
        }

        return DateTimeZone::listIdentifiers(DateTimeZone::PER_COUNTRY, strtoupper($country))
            ?: DateTimeZone::listIdentifiers();
    }

    /**
     * @param int $mcc
     *
     * @return ?\stdClass
     */
    public function mcc(int $mcc): ?stdClass
    {
        static $cache = [];

        if (isset($cache[$mcc])) {
            return $cache[$mcc];
        }

        foreach ($this->mccs() as $each) {
            if ($each->mcc === $mcc) {
                return $cache[$mcc] = $each;
            }
        }

        return null;
    }

    /**
     * @return array
     */
    public function mccs(): array
    {
        static $cache;

        return $cache ??= json_decode(file_get_contents(base_path('resources/app/mcc/mcc.json')));
    }

    /**
     * @param string $message = ''
     * @param string $code = ''
     *
     * @throws \App\Exceptions\NotFoundException
     *
     * @return void
     */
    public function notFound(string $message = '', string $code = ''): void
    {
        throw new NotFoundException($message ?: __('common.error.not-found'), null, null, $code);
    }

    /**
     * @param \Throwable $e
     *
     * @return bool
     */
    public function isExceptionSystem(Throwable $e): bool
    {
        return ($e instanceof Error)
            || ($e instanceof ErrorException)
            || ($e instanceof LogicException)
            || ($e instanceof RuntimeException);
    }
}
