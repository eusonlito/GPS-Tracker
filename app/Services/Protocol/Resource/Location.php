<?php declare(strict_types=1);

namespace App\Services\Protocol\Resource;

class Location extends ResourceAbstract
{
    /**
     * @const array
     */
    protected const ATTRIBUTES = [
        'body', 'maker', 'serial', 'type', 'latitude', 'longitude', 'speed',
        'signal', 'direction', 'datetime', 'timezone', 'country', 'response',
    ];

    /**
     * @return string
     */
    public function format(): string
    {
        return 'location';
    }

    /**
     * @return bool
     */
    public function isValid(): bool
    {
        return $this->maker()
            && $this->serial()
            && $this->type()
            && $this->latitude()
            && $this->longitude()
            && $this->datetime();
    }

    /**
     * @return string
     */
    public function body(): string
    {
        return $this->attribute(__FUNCTION__);
    }

    /**
     * @return string
     */
    public function maker(): string
    {
        return $this->attribute(__FUNCTION__);
    }

    /**
     * @return string
     */
    public function serial(): string
    {
        return $this->attribute(__FUNCTION__);
    }

    /**
     * @return string
     */
    public function type(): string
    {
        return $this->attribute(__FUNCTION__);
    }

    /**
     * @return ?float
     */
    public function latitude(): ?float
    {
        return $this->attribute(__FUNCTION__);
    }

    /**
     * @return ?float
     */
    public function longitude(): ?float
    {
        return $this->attribute(__FUNCTION__);
    }

    /**
     * @return ?float
     */
    public function speed(): ?float
    {
        return $this->attribute(__FUNCTION__);
    }

    /**
     * @return ?int
     */
    public function signal(): ?int
    {
        return $this->attribute(__FUNCTION__);
    }

    /**
     * @return ?int
     */
    public function direction(): ?int
    {
        return $this->attribute(__FUNCTION__);
    }

    /**
     * @return ?string
     */
    public function datetime(): ?string
    {
        return $this->attribute(__FUNCTION__);
    }

    /**
     * @return ?string
     */
    public function timezone(): ?string
    {
        return $this->attribute(__FUNCTION__);
    }

    /**
     * @return ?string
     */
    public function country(): ?string
    {
        return $this->attribute(__FUNCTION__);
    }

    /**
     * @return string
     */
    public function response(): string
    {
        return $this->attribute(__FUNCTION__);
    }
}
