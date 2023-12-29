<?php declare(strict_types=1);

namespace App\Services\Protocol\GT06\Parser;

use App\Services\Protocol\Resource\Location as LocationResource;

class Location extends ParserAbstract
{
    /**
     * @return ?\App\Services\Protocol\Resource\Location
     */
    public function resource(): ?LocationResource
    {
        $this->values = [];

        if ($this->bodyIsValid() === false) {
            return null;
        }

        $this->modules();

        return new LocationResource([
            'body' => $this->body,
            'serial' => $this->serial(),
            'latitude' => $this->latitude(),
            'longitude' => $this->longitude(),
            'speed' => $this->speed(),
            'signal' => $this->signal(),
            'direction' => $this->direction(),
            'datetime' => $this->datetime(),
            'timezone' => $this->timezone(),
            'response' => $this->response(),
        ]);
    }

    /**
     * @return bool
     */
    public function bodyIsValid(): bool
    {
        return ($this->data['serial'] ?? false)
            && (bool)preg_match($this->bodyIsValidRegExp(), $this->body, $this->values);
    }

    /**
     * @return string
     */
    protected function bodyIsValidRegExp(): string
    {
        return '/^'
            .'(7979)'        //  1 - start
            .'([0-9a-f]{4})' //  2 - length
            .'(70)'          //  3 - protocol
            .'/';
    }

    /**
     * @return string
     */
    protected function serial(): string
    {
        return $this->data['serial'];
    }

    /**
     * @return void
     */
    protected function modules(): void
    {
        $body = substr($this->body, 10, -8);

        while (strlen($body) > 12) {
            $type = substr($body, 0, 4);
            $length = hexdec(substr($body, 4, 4)) * 2;
            $content = substr($body, 8, $length);

            match ($type) {
                '0011' => $this->moduleCellTower($content),
                '0033' => $this->moduleGps($content),
                '002C' => $this->moduleTimestamp($content),
                default => null,
            };

            $body = substr($body, 8 + $length);
        }
    }

    /**
     * @param string $content
     *
     * @return void
     */
    protected function moduleGps(string $content): void
    {
        $this->cache['datetime'] = date('Y-m-d H:i:s', hexdec(substr($content, 0, 8)));

        $this->cache['latitude'] = hexdec(substr($content, 14, 8)) / 60 / 30000;
        $this->cache['longitude'] = hexdec(substr($content, 22, 8)) / 60 / 30000;

        $this->cache['speed'] = round(hexdec(substr($content, 30, 2)) * 1.852, 2);

        $flags = substr($content, 23);

        $this->cache['direction'] = hexdec(substr($flags, 2, 2));
        $this->cache['signal'] = hexdec(substr($flags, 8, 2));
    }

    /**
     * @param string $content
     *
     * @return void
     */
    protected function moduleCellTower(string $content): void
    {
        $this->cache['mcc'] = hexdec(substr($content, 0, 4));
        $this->cache['mnc'] = hexdec(substr($content, 4, 4));
    }

    /**
     * @param string $content
     *
     * @return void
     */
    protected function moduleTimestamp(string $content): void
    {
        $this->cache['datetime'] = date('Y-m-d H:i:s', hexdec($content));
    }

    /**
     * @return ?float
     */
    protected function latitude(): ?float
    {
        return $this->cache[__FUNCTION__] ?? null;
    }

    /**
     * @return ?float
     */
    protected function longitude(): ?float
    {
        return $this->cache[__FUNCTION__] ?? null;
    }

    /**
     * @return ?float
     */
    protected function speed(): ?float
    {
        return $this->cache[__FUNCTION__] ?? null;
    }

    /**
     * @return ?int
     */
    protected function signal(): ?int
    {
        return $this->cache[__FUNCTION__] ?? null;
    }

    /**
     * @return ?int
     */
    protected function direction(): ?int
    {
        return $this->cache[__FUNCTION__] ?? null;
    }

    /**
     * @return ?string
     */
    protected function datetime(): ?string
    {
        return $this->cache[__FUNCTION__];
    }

    /**
     * @return ?string
     */
    protected function country(): ?string
    {
        if (isset($this->cache['mcc'], $this->cache['mnc']) === false) {
            return null;
        }

        return $this->cache[__FUNCTION__] ??= helper()->mcc($this->cache['mcc'], $this->cache['mnc'])?->iso;
    }

    /**
     * @return ?string
     */
    protected function timezone(): ?string
    {
        return $this->cache[__FUNCTION__] ??= helper()->latitudeLongitudeTimezone(
            $this->latitude(),
            $this->longitude(),
            $this->country()
        );
    }

    /**
     * @return string
     */
    protected function response(): string
    {
        return '';
    }
}
