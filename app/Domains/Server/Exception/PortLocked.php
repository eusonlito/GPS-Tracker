<?php declare(strict_types=1);

namespace App\Domains\Server\Exception;

class PortLocked extends ExceptionAbstract
{
    /**
     * @var int
     */
    protected $code = 408;

    /**
     * @var ?string
     */
    protected ?string $status = 'server-port-locked';
}
