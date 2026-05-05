<?php declare(strict_types=1);

namespace App\Services\Protocol\OsmAnd\Parser;

use App\Services\Protocol\ParserAbstract;

class Location extends ParserAbstract
{
    /**
     * @return array
     */
    public function resources(): array
    {
        if ($this->messageIsValid() === false) {
            return [];
        }

        $this->addIfValid($this->resourceLocation());

        return $this->resources;
    }

    /**
     * @return bool
     */
    public function messageIsValid(): bool
    {
        $this->values = $this->messageIsValidFromQueryString() ?: $this->messageIsValidFromJson();

        if (empty($this->values)) {
            return false;
        }

        $this->valuesMap();

        return $this->valuesAreValid();
    }

    /**
     * @return array
     */
    protected function messageIsValidFromQueryString(): array
    {
        if (preg_match($this->messageIsValidFromQueryStringExp(), $this->message, $matches) === 0) {
            return [];
        }

        parse_str($matches[2], $values);

        return $values;
    }

    /**
     * @return string
     */
    protected function messageIsValidFromQueryStringExp(): string
    {
        return '/^(GET|POST)\s+\/[^\?]*\?([^\s]*)\s+HTTP\/1(?:\.\d)?/m';
    }

    /**
     * @return array
     */
    protected function messageIsValidFromJson(): array
    {
        $body = $this->messageIsValidFromJsonBody();

        if (empty($body)) {
            return [];
        }

        $values = json_decode($body, true);

        if ((is_array($values) === false) || (json_last_error() !== JSON_ERROR_NONE)) {
            return [];
        }

        return $values;
    }

    /**
     * @return string
     */
    protected function messageIsValidFromJsonBody(): string
    {
        return trim(preg_split("/\r\n\r\n|\n\n|\r\r/", $this->message, 2)[1] ?? '');
    }

    /**
     * @return void
     */
    protected function valuesMap(): void
    {
        $this->values = [
            'id' => $this->valuesMapId(),
            'type' => $this->valuesMapType(),
            'lat' => $this->valuesMapLatitude(),
            'lon' => $this->valuesMapLongitude(),
            'timestamp' => $this->valuesMapTimestamp(),
            'speed' => $this->valuesMapSpeed(),
            'direction' => $this->valuesMapDirection(),
            'valid' => $this->valuesMapValid(),
        ];
    }

    /**
     * @return ?string
     */
    protected function valuesMapId(): ?string
    {
        $value = $this->valueFirst([
            'deviceid',
            'deviceId',
            'device_id',
            'id',
            'uniqueid',
            'uniqueId',
            'unique_id',
            'device.id',
            'device.identifier',
            'device.uniqueId',
            'location.deviceid',
            'location.deviceId',
            'location.device_id',
            'location.id',
            'location.uniqueid',
            'location.uniqueId',
            'location.unique_id',
        ]);

        return ($value === null) ? null : strval($value);
    }

    /**
     * @return ?string
     */
    protected function valuesMapType(): ?string
    {
        $value = $this->valueFirst([
            'type',
            'event',
            'location.type',
        ]);

        return ($value === null) ? null : strval($value);
    }

    /**
     * @return ?float
     */
    protected function valuesMapLatitude(): ?float
    {
        return $this->valueFloat($this->valueFirst([
            'lat',
            'latitude',
            'location.lat',
            'location.latitude',
            'location.coords.lat',
            'location.coords.latitude',
            'coords.lat',
            'coords.latitude',
            'position.lat',
            'position.latitude',
        ]));
    }

    /**
     * @return ?float
     */
    protected function valuesMapLongitude(): ?float
    {
        return $this->valueFloat($this->valueFirst([
            'lon',
            'lng',
            'longitude',
            'location.lon',
            'location.lng',
            'location.longitude',
            'location.coords.lon',
            'location.coords.lng',
            'location.coords.longitude',
            'coords.lon',
            'coords.lng',
            'coords.longitude',
            'position.lon',
            'position.lng',
            'position.longitude',
        ]));
    }

    /**
     * @return ?int
     */
    protected function valuesMapTimestamp(): ?int
    {
        return $this->valueTimestamp($this->valueFirst([
            'timestamp',
            'time',
            'datetime',
            'date',
            'location.timestamp',
            'location.time',
            'location.datetime',
            'position.timestamp',
            'position.time',
        ]));
    }

    /**
     * @return float
     */
    protected function valuesMapSpeed(): float
    {
        return $this->valueFloat($this->valueFirst([
            'speed',
            'location.speed',
            'location.coords.speed',
            'coords.speed',
            'position.speed',
        ])) ?? 0.0;
    }

    /**
     * @return int
     */
    protected function valuesMapDirection(): int
    {
        return intval($this->valueFirst([
            'direction',
            'bearing',
            'heading',
            'course',
            'location.direction',
            'location.bearing',
            'location.heading',
            'location.coords.direction',
            'location.coords.bearing',
            'location.coords.heading',
            'coords.direction',
            'coords.bearing',
            'coords.heading',
            'position.direction',
            'position.bearing',
            'position.heading',
        ]) ?? 0);
    }

    /**
     * @return bool
     */
    protected function valuesMapValid(): bool
    {
        return $this->valueBool($this->valueFirst([
            'valid',
            'location.valid',
            'position.valid',
        ]), true);
    }

    /**
     * @return bool
     */
    protected function valuesAreValid(): bool
    {
        return is_string($this->values['id'])
            && ($this->values['id'] !== '')
            && ($this->values['lat'] !== null)
            && ($this->values['lon'] !== null)
            && ($this->values['timestamp'] !== null)
            && ($this->values['timestamp'] > 0);
    }

    /**
     * @param array $keys
     *
     * @return mixed
     */
    protected function valueFirst(array $keys): mixed
    {
        foreach ($keys as $key) {
            $value = $this->arrayGet($key);

            if (($value !== null) && ($value !== '')) {
                return $value;
            }
        }

        return null;
    }

    /**
     * @param string $path
     *
     * @return mixed
     */
    protected function arrayGet(string $path): mixed
    {
        if (str_contains($path, '.') === false) {
            return $this->values[$path] ?? null;
        }

        $current = $this->values;

        foreach (explode('.', $path) as $segment) {
            if ((is_array($current) === false) || (array_key_exists($segment, $current) === false)) {
                return null;
            }

            $current = $current[$segment];
        }

        return $current;
    }

    /**
     * @param mixed $value
     *
     * @return ?float
     */
    protected function valueFloat(mixed $value): ?float
    {
        if (($value === null) || ($value === '')) {
            return null;
        }

        if (is_numeric($value) === false) {
            return null;
        }

        return floatval($value);
    }

    /**
     * @param mixed $value
     *
     * @return ?int
     */
    protected function valueTimestamp(mixed $value): ?int
    {
        if (($value === null) || ($value === '')) {
            return null;
        }

        if (is_numeric($value)) {
            $timestamp = intval($value);

            if ($timestamp > 9999999999) {
                return intval(floor($timestamp / 1000));
            }

            return $timestamp;
        }

        if (is_string($value)) {
            $timestamp = strtotime($value);

            if ($timestamp !== false) {
                return $timestamp;
            }
        }

        return null;
    }

    /**
     * @param mixed $value
     * @param bool $default
     *
     * @return bool
     */
    protected function valueBool(mixed $value, bool $default): bool
    {
        if (($value === null) || ($value === '')) {
            return $default;
        }

        if (is_bool($value)) {
            return $value;
        }

        if (is_numeric($value)) {
            return intval($value) !== 0;
        }

        if (is_string($value)) {
            return in_array(strtolower($value), ['1', 'true', 'yes', 'y', 'on', 'valid'], true);
        }

        return $default;
    }

    /**
     * @return string
     */
    protected function serial(): string
    {
        return $this->values['id'];
    }

    /**
     * @return ?string
     */
    protected function type(): ?string
    {
        return $this->values['type'] ?? null;
    }

    /**
     * @return float
     */
    protected function latitude(): float
    {
        return $this->values['lat'];
    }

    /**
     * @return float
     */
    protected function longitude(): float
    {
        return $this->values['lon'];
    }

    /**
     * @return float
     */
    protected function speed(): float
    {
        return round($this->values['speed'], 2);
    }

    /**
     * @return int
     */
    protected function signal(): int
    {
        return intval($this->values['valid']);
    }

    /**
     * @return int
     */
    protected function direction(): int
    {
        return $this->values['direction'];
    }

    /**
     * @return ?string
     */
    protected function datetime(): ?string
    {
        return date('Y-m-d H:i:s', $this->values['timestamp']);
    }

    /**
     * @return ?string
     */
    protected function country(): ?string
    {
        return null;
    }

    /**
     * @return ?string
     */
    protected function timezone(): ?string
    {
        return helper()->latitudeLongitudeTimezone($this->latitude(), $this->longitude(), $this->country());
    }

    /**
     * @return string
     */
    protected function response(): string
    {
        return implode("\r\n", $this->responseHeaders())."\r\n\r\n";
    }

    /**
     * @return array
     */
    protected function responseHeaders(): array
    {
        return [
            'HTTP/1.1 200 OK',
            'Date: '.gmdate('r'),
            'Server: '.config('app.name'),
            'Cache-Control: no-cache, private',
            'Connection: close',
            'Content-Type: text/html; charset=UTF-8',
        ];
    }
}
