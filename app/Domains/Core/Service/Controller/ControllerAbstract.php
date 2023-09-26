<?php declare(strict_types=1);

namespace App\Domains\Core\Service\Controller;

abstract class ControllerAbstract
{
    /**
     * @return self
     */
    public static function new()
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
