<?php declare(strict_types=1);

namespace App\Services\Protocol\TK102\Parser;

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

        $this->values = explode(',', $this->message);

        $this->addIfValid($this->resourceLocation());

        return $this->resources;
    }

    /**
     * @return bool
     */
    public function messageIsValid(): bool
    {
        return $this->messageIsValidParse()
            && $this->messageIsValidType();
    }

    /**
     * @return bool
     */
    public function messageIsValidParse(): bool
    {
        return (bool)preg_match($this->messageIsValidRegExp(), $this->message);
    }

    /**
     * @return string
     */
    protected function messageIsValidRegExp(): string
    {
        return '/^'
            .'[0-9]{10,},'           //  0 - local date/time (yymmddhhnn)
            .'[\+0-9]*,'             //  1 - admin phone
            .'GPRMC,'                //  2 - GPRMC sub-protocol part signature
            .'[0-9]+\.[0-9]+,'       //  3 - GPS time (hhnnss.tps)
            .'[AV],'                 //  4 - position status (A = data valid, V = data invalid)
            .'[0-9]+\.[0-9]+,'       //  5 - latitude
            .'[NS],'                 //  6 - latitude direction
            .'[0-9]+\.[0-9]+,'       //  7 - longitude
            .'[EW],'                 //  8 - longitude direction
            .'[0-9]+\.[0-9]+,'       //  9 - speed
            .'[0-9\.]*,'             // 10 - direction
            .'[0-9]+,'               // 11 - GPS date (ddmmyy)
            .'[0-9\.]*,'             // 12 - magnetic variation
            .'[EW]?,'                // 13 - magnetic variation direction
            .'[ADEMN]\*[0-9A-F]{2},' // 14 - positioning system mode indicator (A = Autonomous, N = Data not valid), asterisk instead of comma, 16-bit hex checksum
            .'[FL],'                 // 15 - GPS signal level (F = good, L = bad)
            .'(.+,)?'                // 16 - optional "help me" with comma if SOS button pressed
            .'imei:[0-9]+,'          // 16 or 17 - serial
            .'[0-9]+'                // 17 or 18 - altitude? (plus some garbage)
            .'/';
    }

    /**
     * @return bool
     */
    public function messageIsValidType(): bool
    {
        return intval(substr($this->message, 0, 10)) !== 0;
    }

    /**
     * @return string
     */
    protected function serial(): string
    {
        $index = 16;

        if (str_starts_with($this->values[$index], 'imei') === false) {
            $index++; // SOS button pressed
        }

        return trim(explode(':', $this->values[$index])[1]);
    }

    /**
     * @return float
     */
    protected function latitude(): float
    {
        if (isset($this->cache[__FUNCTION__])) {
            return $this->cache[__FUNCTION__];
        }

        $degree = (int)substr($this->values[5], 0, 2);
        $minute = (float)substr($this->values[5], 2);
        $direction = (float)str_replace(['S', 'N'], ['-1', '1'], $this->values[6]);

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

        $degree = (int)substr($this->values[7], 0, 3);
        $minute = (float)substr($this->values[7], 3);
        $direction = (float)str_replace(['W', 'E'], ['-1', '1'], $this->values[8]);

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
        return round((float)$this->values[9] * 1.852, 2);
    }

    /**
     * @return int
     */
    protected function signal(): int
    {
        return ($this->values[15] === 'F') ? 1 : 0;
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
        $date = str_split($this->values[11], 2);
        $time = str_split(substr($this->values[3], 0, 6), 2);

        if (count($date) !== 3 || count($time) !== 3) {
            return null;
        }

        return '20'.$date[2].'-'.$date[1].'-'.$date[0].' '.$time[0].':'.$time[1].':'.$time[2];
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
        return '';
    }
}
