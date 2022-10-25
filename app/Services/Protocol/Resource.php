<?php declare(strict_types=1);

namespace App\Services\Protocol;

class Resource
{
    /**
     * @const array
     */
    protected const ATTRIBUTES = [
        'body', 'maker', 'serial', 'type', 'latitude', 'longitude', 'speed',
        'signal', 'direction', 'datetime', 'timezone', 'country', 'response',
    ];

    /**
     * @var array
     */
    protected array $attributes;

    /**
     * @return self
     */
    public static function new(): self
    {
        return new static(...func_get_args());
    }

    /**
     * @param array $attributes
     *
     * @return self
     */
    public function __construct(array $attributes)
    {
        $this->attributes($attributes);
    }

    /**
     * @param array $attributes
     *
     * @return void
     */
    protected function attributes(array $attributes): void
    {
        array_map(fn ($key) => $this->attributes[$key] = $attributes[$key] ?? null, static::ATTRIBUTES);
    }

    /**
     * @param string $key
     *
     * @return mixed
     */
    protected function attribute(string $key): mixed
    {
        return $this->attributes[$key] ?? null;
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
     * @return ?string
     */
    public function body(): ?string
    {
        return $this->attribute(__FUNCTION__);
    }

    /**
     * @return ?string
     */
    public function maker(): ?string
    {
        return $this->attribute(__FUNCTION__);
    }

    /**
     * @return ?string
     */
    public function serial(): ?string
    {
        return $this->attribute(__FUNCTION__);
    }

    /**
     * @return ?string
     */
    public function type(): ?string
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
     * @return ?string
     */
    public function response(): ?string
    {
        return $this->attribute(__FUNCTION__);
    }
}
