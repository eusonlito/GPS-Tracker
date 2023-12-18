<?php declare(strict_types=1);

namespace App\Services\Protocol\GPS103\Parser;

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

        $this->values = explode(',', $this->body);

        return new LocationResource([
            'body' => $this->body,
            'serial' => $this->serial(),
            'type' => $this->type(),
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
        return (bool)preg_match($this->bodyIsValidRegExp(), $this->body);
    }

    /**
     * @return string
     */
    protected function bodyIsValidRegExp(): string
    {
        return '/^'
            .'imei:[0-9]+,'          //  0 - serial
            .'[^,]*,'                //  1 - type
            .'[0-9]{6,},'            //  2 - datetime
            .'[^,]*,'                //  3 - rfid
            .'[FL],'                 //  4 - signal
            .'[0-9\.]+,'             //  5 - fix time
            .'[AV],'                 //  6 - signal
            .'[0-9]+\.[0-9]+,'       //  7 - latitude
            .'[NS],'                 //  8 - latitude direction
            .'[0-9]+\.[0-9]+,'       //  9 - longitude
            .'[EW],'                 // 10 - longitude direction
            .'[0-9]+\.[0-9]+,'       // 11 - speed
            .'[0-9\.]*,?'            // 12 - direction
            .'/';
    }

    /**
     * @return string
     */
    protected function serial(): string
    {
        return explode(':', $this->values[0])[1];
    }

    /**
     * @return ?string
     */
    protected function type(): ?string
    {
        return $this->values[1];
    }

    /**
     * @return float
     */
    protected function latitude(): float
    {
        if (isset($this->cache[__FUNCTION__])) {
            return $this->cache[__FUNCTION__];
        }

        $degree = (int)substr($this->values[7], 0, 2);
        $minute = (float)substr($this->values[7], 2);
        $direction = (float)str_replace(['S', 'N'], ['-1', '1'], $this->values[8]);

        $latitude = round(($degree + ($minute / 60)) * $direction, 5);

        if (($latitude < -90) || ($latitude > 90)) {
            $latitude = 0.0;
        }

        return $this->cache[__FUNCTION__] = $latitude;
    }

    /**
     * @return float
     */
    protected function longitude(): float
    {
        if (isset($this->cache[__FUNCTION__])) {
            return $this->cache[__FUNCTION__];
        }

        $degree = (int)substr($this->values[9], 0, 3);
        $minute = (float)substr($this->values[9], 3);
        $direction = (float)str_replace(['W', 'E'], ['-1', '1'], $this->values[10]);

        $longitude = round(($degree + ($minute / 60)) * $direction, 5);

        if (($longitude < -180) || ($longitude > 180)) {
            $longitude = 0.0;
        }

        return $this->cache[__FUNCTION__] = $longitude;
    }

    /**
     * @return float
     */
    protected function speed(): float
    {
        return round((float)$this->values[11], 2);
    }

    /**
     * @return int
     */
    protected function signal(): int
    {
        return $this->values[4] === 'F' ? 1 : 0;
    }

    /**
     * @return int
     */
    protected function direction(): int
    {
        return intval($this->values[12]);
    }

    /**
     * @return ?string
     */
    protected function datetime(): ?string
    {
        $fix = explode('.', $this->values[5])[0];

        if (strlen($fix) === 6) {
            $value = substr($this->values[2], 0, 6).$fix;
        } else {
            $value = $this->values[2];
        }

        $date = str_split($value, 2);

        if (count($date) !== 6) {
            return null;
        }

        return '20'.$date[0].'-'.$date[1].'-'.$date[2].' '.$date[3].':'.$date[4].':'.$date[5];
    }

    /**
     * @return ?string
     */
    protected function timezone(): ?string
    {
        return $this->cache[__FUNCTION__] ??= helper()->latitudeLongitudeTimezone(
            $this->latitude(),
            $this->longitude(),
        );
    }

    /**
     * @return string
     */
    protected function response(): string
    {
        return 'ON';
    }
}
