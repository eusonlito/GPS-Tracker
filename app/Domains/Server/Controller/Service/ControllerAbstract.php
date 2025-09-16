<?php declare(strict_types=1);

namespace App\Domains\Server\Controller\Service;

abstract class ControllerAbstract
{
    /**
     * @return self
     */
    public static function new(): self
    {
        return new static(...func_get_args());
    }
}
