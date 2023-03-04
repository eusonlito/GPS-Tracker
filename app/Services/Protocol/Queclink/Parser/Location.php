<?php declare(strict_types=1);

namespace App\Services\Protocol\Queclink\Parser;

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

        $this->values = explode(',', substr($this->body, 0, -1));

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
        return (bool)preg_match($this->bodyIsValidRegExp(), $this->body);
    }

    /**
     * @return string
     */
    protected function bodyIsValidRegExp(): string
    {
        return '/^'
            .'\+(RESP|BUFF):GTFRI,'  //  0 - response code
            .'[A-Z0-9]+,'            //  1 - protocol version
            .'[0-9]+,'               //  2 - serial
            .','                     //  3 - reserved
            .'[a-zA-Z0-9_-]+,'       //  4 - device name
            .'[0-9]+,'               //  5 - external power voltage
            .'[0-9A-Z]+,'            //  6 - report id
            .'[0-9]+,'               //  7 - number
            .'[0-9]+,'               //  8 - gnss accuracy
            .'[0-9\.]+,'             //  9 - speed
            .'[0-9]+,'               // 10 - direction
            .'\-?[0-9]+\.,'          // 11 - altitude
            .'\-?[0-9]+\.,'          // 12 - longitude
            .'\-?[0-9]+\.,'          // 13 - latitude
            .'[0-9]+,'               // 14 - utc time
            .'[0-9]+,'               // 15 - mcc
            .'[0-9]+,'               // 16 - mnc
            .'[0-9]+,'               // 17 - lac
            .'[A-Z0-9]+,'            // 18 - cell id
            .'/';
    }

    /**
     * @return string
     */
    protected function maker(): string
    {
        return 'Queclink';
    }

    /**
     * @return string
     */
    protected function serial(): string
    {
        return $this->values[2];
    }

    /**
     * @return string
     */
    protected function type(): string
    {
        return $this->values[0];
    }

    /**
     * @return float
     */
    protected function latitude(): float
    {
        return floatval($this->values[13]);
    }

    /**
     * @return float
     */
    protected function longitude(): float
    {
        return floatval($this->values[12]);
    }

    /**
     * @return float
     */
    protected function speed(): float
    {
        return floatval($this->values[9]);
    }

    /**
     * @return int
     */
    protected function signal(): int
    {
        return intval($this->values[8]);
    }

    /**
     * @return int
     */
    protected function direction(): int
    {
        return intval($this->values[10]);
    }

    /**
     * @return string
     */
    protected function datetime(): string
    {
        $date = str_split($this->values[14], 2);

        return $date[0].$date[1].'-'.$date[2].'-'.$date[3].' '.$date[4].':'.$date[5].':'.$date[6];
    }

    /**
     * @return ?string
     */
    protected function country(): ?string
    {
        return $this->cache[__FUNCTION__] ??= helper()->mcc(intval($this->values[15]))?->iso;
    }

    /**
     * @return ?string
     */
    protected function timezone(): ?string
    {
        return $this->cache[__FUNCTION__] ??= helper()->latitudeLongitudeTimezone($this->latitude(), $this->longitude(), $this->country());
    }

    /**
     * @return string
     */
    protected function response(): string
    {
        return $this->body;
    }
}
