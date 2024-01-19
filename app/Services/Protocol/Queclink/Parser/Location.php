<?php declare(strict_types=1);

namespace App\Services\Protocol\Queclink\Parser;

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

        $this->values = explode(',', substr($this->body, 0, -1));

        $this->addIfValid($this->resourceLocation());

        return $this->resources;
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
            .'\+(RESP|BUFF):GTFRI,'        //  0 - response code
            .'[0-9A-Z]+,'                  //  1 - protocol version
            .'[0-9]{15},'                  //  2 - serial
            .'[0-9A-Za-z_-]{0,20},'        //  3 - device name
            .','                           //  4 - reserved
            .'[0-9]{0,5},'                 //  5 - external power voltage
            .'[0-9]{2},'                   //  6 - report id
            .'[0-9]{1,2},'                 //  7 - number
            .'[0-9]{1,2},'                 //  8 - gnss accuracy
            .'[0-9]{1,3}\.[0-9],'          //  9 - speed
            .'[0-9]{1,3},'                 // 10 - direction
            .'\-?[0-9]{1,5}\.[0-9],'       // 11 - altitude
            .'\-?[0-9]{1,3}\.[0-9]{0,6},'  // 12 - longitude
            .'\-?[0-9]{1,2}\.[0-9]{0,6},'  // 13 - latitude
            .'[0-9]{14},'                  // 14 - utc time
            .'[0-9A-Z]{0,4},'              // 15 - mcc
            .'[0-9A-Z]{0,4},'              // 16 - mnc
            .'[0-9A-Z]{0,4},'              // 17 - lac
            .'[0-9A-Z]{0,8},'              // 18 - cell id
            .'/';
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
        return explode(':', $this->values[0])[1];
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
        return $this->cache[__FUNCTION__] ??= helper()->mcc(
            intval($this->values[15]),
            intval($this->values[16])
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
        return '+SACK:'.end($this->values).'$';
    }
}
