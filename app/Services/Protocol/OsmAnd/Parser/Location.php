<?php declare(strict_types=1);

namespace App\Services\Protocol\OsmAnd\Parser;

use App\Services\Protocol\Resource\Location as LocationResource;

class Location extends ParserAbstract
{
    /**
     * @return ?\App\Services\Protocol\Resource\Location
     */
    public function resource(): ?LocationResource
    {
        if ($this->bodyIsValid() === false) {
            return null;
        }

        return new LocationResource([
            'body' => $this->body,
            'maker' => $this->maker(),
            'serial' => $this->serial(),
            'type' => $this->type(),
            'latitude' => $this->latitude(),
            'longitude' => $this->longitude(),
            'speed' => $this->speed(),
            'signal' => $this->signal(),
            'direction' => $this->direction(),
            'datetime' => $this->datetime(),
            'country' => $this->country(),
            'timezone' => $this->timezone(),
            'response' => $this->response(),
        ]);
    }

    /**
     * @return bool
     */
    public function bodyIsValid(): bool
    {
        $this->bodyIsValid ??= (bool)preg_match($this->bodyIsValidRegExp(), $this->body, $matches);

        if ($this->bodyIsValid === false) {
            return false;
        }

        parse_str($matches[1], $this->values);

        return $this->bodyIsValid = ($this->values['id'] ?? false)
            && ($this->values['lat'] ?? false)
            && ($this->values['lon'] ?? false)
            && ($this->values['timestamp'] ?? false)
            && ($this->values['speed'] ?? false);
    }

    /**
     * @return string
     */
    protected function bodyIsValidRegExp(): string
    {
        return '/GET \/\?(.*) HTTP\/1/';
    }

    /**
     * @return ?string
     */
    protected function maker(): ?string
    {
        return $this->values['maker'] ?? null;
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
        return floatval($this->values['lat']);
    }

    /**
     * @return float
     */
    protected function longitude(): float
    {
        return floatval($this->values['lon']);
    }

    /**
     * @return float
     */
    protected function speed(): float
    {
        return round(floatval($this->values['speed']), 2);
    }

    /**
     * @return int
     */
    protected function signal(): int
    {
        return intval($this->values['hdop'] ?? 1);
    }

    /**
     * @return int
     */
    protected function direction(): int
    {
        return 0;
    }

    /**
     * @return ?string
     */
    protected function datetime(): ?string
    {
        return date('Y-m-d H:i:s', (int)$this->values['timestamp']);
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
