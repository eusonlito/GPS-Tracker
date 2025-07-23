<?php declare(strict_types=1);

namespace App\Services\Protocol\H02\Parser;

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

        $this->values = explode(',', substr($this->message, 1, -1));

        $this->addIfValid($this->resourceLocation());

        return $this->resources;
    }

    /**
     * @return bool
     */
    public function messageIsValid(): bool
    {
        return (bool)preg_match($this->messageIsValidRegExp(), $this->message);
    }

    /**
     * @return string
     */
    protected function messageIsValidRegExp(): string
    {
        return '/^'
            .'\*[A-Z]{2},'           //  0 - maker
            .'[0-9]+,'               //  1 - serial
            .'V[15],'                //  2 - type (V1,V5)
            .'[0-9]{6},'             //  3 - time
            .'[VA],'                 //  4 - signal
            .'[0-9]{4}\.[0-9]{4},'   //  5 - latitude
            .'[NS],'                 //  6 - latitude direction
            .'[0-9]{4,5}\.[0-9]{4},' //  7 - longitude (V1=5,V5=4)
            .'[EW],'                 //  8 - longitude direction
            .'[0-9]{0,3}\.[0-9]{2},' //  9 - speed
            .'[0-9]{0,3},'           // 10 - direction
            .'[0-9]{6},'             // 11 - date
            .'[0-9a-fA-F]{8},'       // 12 - status
            .'[0-9]+,'               // 13 - mcc
            .'[0-9]+,'               // 14 - mnc
            .'/';
    }

    /**
     * @return ?string
     */
    protected function maker(): ?string
    {
        return $this->values[0];
    }

    /**
     * @return string
     */
    protected function serial(): string
    {
        return $this->values[1];
    }

    /**
     * @return ?string
     */
    protected function type(): ?string
    {
        return $this->values[2];
    }

    /**
     * @return float
     */
    protected function latitude(): float
    {
        if (isset($this->cache[__FUNCTION__])) {
            return $this->cache[__FUNCTION__];
        }

        $degree = intval(substr($this->values[5], 0, 2));
        $minute = floatval(substr($this->values[5], 2, 7));
        $direction = floatval(str_replace(['S', 'N'], ['-1', '1'], $this->values[6]));

        return $this->cache[__FUNCTION__] = round(($degree + ($minute / 60)) * $direction, 5);
    }

    /**
     * @return float
     */
    protected function longitude(): float
    {
        if (isset($this->cache[__FUNCTION__])) {
            return $this->cache[__FUNCTION__];
        }

        $longitude = $this->values[7];
        $direction = floatval(str_replace(['W', 'E'], ['-1', '1'], $this->values[8]));

        if ($this->type() === 'V1') {
            $degree = intval(substr($longitude, 0, 3));
            $minute = floatval(substr($longitude, 3, 7));
        } else {
            $degree = intval(substr($longitude, 0, 2));
            $minute = floatval(substr($longitude, 2, 7));
        }

        return $this->cache[__FUNCTION__] = round(($degree + ($minute / 60)) * $direction, 5);
    }

    /**
     * @return float
     */
    protected function speed(): float
    {
        return round(floatval($this->values[9]) * 1.852, 2);
    }

    /**
     * @return int
     */
    protected function signal(): int
    {
        return $this->values[4] === 'A' ? 1 : 0;
    }

    /**
     * @return int
     */
    protected function direction(): int
    {
        return intval($this->values[10]);
    }

    /**
     * @return ?string
     */
    protected function datetime(): ?string
    {
        $value = $this->values[11].$this->values[3];

        if (preg_match('/^0+$/', $value)) {
            return null;
        }

        $date = str_split($value, 2);

        return '20'.$date[2].'-'.$date[1].'-'.$date[0].' '.$date[3].':'.$date[4].':'.$date[5];
    }

    /**
     * @return ?string
     */
    protected function country(): ?string
    {
        return $this->cache[__FUNCTION__] ??= helper()->mcc(
            intval($this->values[13]),
            intval($this->values[14])
        )?->iso;
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
        return '*'.$this->maker().','.$this->serial().',V4,'.$this->type().','.date('YmdHis').'#';
    }
}
