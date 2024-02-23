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
        if ($this->bodyIsValid() === false) {
            return [];
        }

        $this->addIfValid($this->resourceLocation());

        return $this->resources;
    }

    /**
     * @return bool
     */
    public function bodyIsValid(): bool
    {
        if (preg_match($this->bodyIsValidRegExp(), $this->body, $matches) === 0) {
            return false;
        }

        parse_str($matches[1], $this->values);

        return ($this->values['id'] ?? false)
            && ($this->values['lat'] ?? false)
            && ($this->values['lon'] ?? false)
            && ($this->values['timestamp'] ?? false)
            && isset($this->values['speed']);
    }

    /**
     * @return string
     */
    protected function bodyIsValidRegExp(): string
    {
        return '/GET \/\?(.*) HTTP\/1/';
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
        return intval($this->values['direction'] ?? 0);
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
