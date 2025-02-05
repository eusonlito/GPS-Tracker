<?php declare(strict_types=1);

namespace App\Services\Protocol\Aquila\Parser;

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

        $this->values = explode(',', substr($this->message, 2, -3));

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
            .'\$\$[^,]*,'            //  0 - client
            .'[0-9]+,'               //  1 - serial
            .'[0-9]+,'               //  2 - type
            .'-?[0-9]+\.[0-9]+,'     //  3 - latitude
            .'-?[0-9]+\.[0-9]+,'     //  4 - longitude
            .'[0-9]{12},'            //  5 - datetime
            .'[VA],'                 //  6 - signal
            .'[0-9]+,'               //  7 - gsm
            .'[0-9]{1,3},'           //  8 - speed
            .'[0-9]+,'               //  9 - odometer
            .'[0-9]{1,3},'           // 10 - direction
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
        return floatval($this->values[3]);
    }

    /**
     * @return float
     */
    protected function longitude(): float
    {
        return floatval($this->values[4]);
    }

    /**
     * @return float
     */
    protected function speed(): float
    {
        return floatval($this->values[8]);
    }

    /**
     * @return int
     */
    protected function signal(): int
    {
        return $this->values[6] === 'A' ? 1 : 0;
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
        if (preg_match('/^0+$/', $this->values[5])) {
            return null;
        }

        return sprintf('20%s-%s-%s %s:%s:%s', ...str_split($this->values[5], 2));
    }

    /**
     * @return ?string
     */
    protected function timezone(): ?string
    {
        return helper()->latitudeLongitudeTimezone(
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
