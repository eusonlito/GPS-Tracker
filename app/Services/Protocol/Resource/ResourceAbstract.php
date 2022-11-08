<?php declare(strict_types=1);

namespace App\Services\Protocol\Resource;

abstract class ResourceAbstract
{
    /**
     * @var array
     */
    protected array $attributes;

    /**
     * @return string
     */
    abstract protected function format(): string;

    /**
     * @return bool
     */
    abstract public function isValid(): bool;

    /**
     * @return string
     */
    abstract protected function body(): string;

    /**
     * @return string
     */
    abstract protected function maker(): string;

    /**
     * @return string
     */
    abstract protected function serial(): string;

    /**
     * @return string
     */
    abstract protected function type(): string;

    /**
     * @return string
     */
    abstract protected function response(): string;

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
}
