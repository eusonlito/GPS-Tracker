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
        if (preg_match($this->messageIsValidRegExp(), $this->message, $matches) === 0) {
            return false;
        }

        parse_str($matches[2], $this->values);

        $this->valuesMap();

        return $this->values['id']
            && $this->values['lat']
            && $this->values['lon']
            && $this->values['timestamp'];
    }

    /**
     * @return string
     */
    protected function messageIsValidRegExp(): string
    {
        return '/(GET|POST) \/[^\?]*\?(.*) HTTP\/1/';
    }

    /**
     * @return void
     */
    protected function valuesMap(): void
    {
        $this->values = [
            'id' => $this->values['deviceid'] ?? $this->values['id'] ?? null,
            'lat' => floatval($this->values['lat'] ?? 0),
            'lon' => floatval($this->values['lon'] ?? 0),
            'timestamp' => intval($this->values['timestamp'] ?? 0),
            'speed' => floatval($this->values['speed'] ?? 0),
            'direction' => intval($this->values['direction'] ?? $this->values['bearing'] ?? 0),
            'valid' => boolval($this->values['valid'] ?? true),
        ];
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
