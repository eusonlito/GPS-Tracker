<?php declare(strict_types=1);

namespace App\Domains\Server\Service\Controller;

use Illuminate\Http\Request;

abstract class ControllerAbstract
{
    /**
     * @return self
     */
    public static function new(): self
    {
        return new static(...func_get_args());
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return self
     */
    public function __construct(protected Request $request)
    {
    }
}
