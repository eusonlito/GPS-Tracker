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
     *
     * @return ?bool
     */
    protected function boolValue(string $key): ?bool
    {
        if (strlen($value = (string)$this->request->input($key))) {
            return (bool)$value;
        }

        return null;
    }
}
