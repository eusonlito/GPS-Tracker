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
    abstract public function format(): string;

    /**
     * @return bool
     */
    abstract public function isValid(): bool;

    /**
     * @return string
     */
    abstract public function body(): string;

    /**
     * @return string
     */
    abstract public function serial(): string;

    /**
     * @return string
     */
    abstract public function response(): string;

    /**
     * @return array
     */
    abstract protected function attributesAvailable(): array;

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
        array_map(fn ($key) => $this->attributes[$key] = $attributes[$key] ?? null, $this->attributesAvailable());
    }

    /**
     * @param string $key
     * @param mixed $default = null
     *
     * @return mixed
     */
    protected function attribute(string $key, mixed $default = null): mixed
    {
        return $this->attributes[$key] ?? $default;
    }

    /**
     * @return array
     */
    public function data(): array
    {
        return $this->attribute(__FUNCTION__, []);
    }
}
