<?php declare(strict_types=1);

namespace App\Domains\Server\Exception;

class PortBusy extends ExceptionAbstract
{
    /**
     * @var int
     */
    protected $code = 412;

    /**
     * @var ?string
     */
    protected ?string $status = 'server-port-busy';
}
