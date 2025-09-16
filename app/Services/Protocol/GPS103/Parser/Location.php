<?php declare(strict_types=1);

namespace App\Services\Protocol\GPS103\Parser;

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
        return (bool)preg_match($this->typeIsValidParseExp(), $this->message);
    }

    /**
     * @return string
     */
    protected function typeIsValidParseExp(): string
    {
        return '/^'
            .'imei:[0-9]+,'    //  0 - serial
            .'[^,]*,'          //  1 - type
            .'[0-9]{6,},'      //  2 - datetime
            .'[^,]*,'          //  3 - rfid
            .'[FL],'           //  4 - signal
            .'[0-9\.]+,'       //  5 - fix time
            .'[AV],'           //  6 - signal
            .'[0-9]+\.[0-9]+,' //  7 - latitude
            .'[NS],'           //  8 - latitude direction
            .'[0-9]+\.[0-9]+,' //  9 - longitude
            .'[EW],'           // 10 - longitude direction
            .'[0-9]+\.[0-9]+,' // 11 - speed
            .'[0-9\.]*,?'      // 12 - direction
            .'/';
    }

    /**
     * @return bool
     */
    public function messageIsValidType(): bool
    {
        $type = explode(',', $this->message, 3)[1];

        return ($type === '001')
            || (is_numeric($type) === false);
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

        $degree = intval(substr($this->values[7], 0, 2));
        $minute = floatval(substr($this->values[7], 2));
        $direction = floatval(str_replace(['S', 'N'], ['-1', '1'], $this->values[8]));

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

        $degree = intval(substr($this->values[9], 0, 3));
        $minute = floatval(substr($this->values[9], 3));
        $direction = floatval(str_replace(['W', 'E'], ['-1', '1'], $this->values[10]));

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
        return round(floatval($this->values[11]) * 1.852, 2);
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
        $date = str_split($this->values[2], 2);

        if (count($date) < 5) {
            return null;
        }

        $date = '20'.$date[0].'-'.$date[1].'-'.$date[2].' '.$date[3].':'.$date[4].':'.($date[5] ?? '');

        if (str_ends_with($date, ':') === false) {
            return $date;
        }

        if (($this->data['date'] ?? null) !== $date) {
            $this->data['date'] = $date;
            $this->data['seconds'] = -5;
        }

        $this->data['seconds'] += 5;

        return $date.sprintf('%02d', $this->data['seconds']);
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
     * @return array
     */
    protected function data(): array
    {
        return [
            'date' => $this->data['date'] ?? null,
            'seconds' => $this->data['seconds'] ?? -5,
        ];
    }

    /**
     * @return string
     */
    protected function response(): string
    {
        return match ($this->type()) {
            'help me' => $this->responseHelpMe(),
            default => $this->responseDefault(),
        };
    }

    /**
     * @return string
     */
    protected function responseHelpMe(): string
    {
        return '**,'.$this->values[0].',E;';
    }

    /**
     * @return string
     */
    protected function responseDefault(): string
    {
        return '';
    }
}
