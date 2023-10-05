<?php declare(strict_types=1);

namespace App\Domains\Core\Service\Controller;

abstract class ControllerAbstract
{
    /**
     * @var array
     */
    protected array $cache = [];

    /**
     * @return self
     */
    public static function new(): self
    {
        return new static(...func_get_args());
    }

    /**
     * @param string $key
     * @param ?array $default = null
     *
     * @return ?array
     */
    protected function requestArray(string $key, ?array $default = null): ?array
    {
        return (array)$this->request->input($key) ?: $default;
    }

    /**
     * @param string $key
     * @param ?bool $default = null
     *
     * @return ?bool
     */
    protected function requestBool(string $key, ?bool $default = null): ?bool
    {
        return match ($this->request->input($key)) {
            'true', '1' => true,
            'false', '0' => false,
            default => $default,
        };
    }
}
