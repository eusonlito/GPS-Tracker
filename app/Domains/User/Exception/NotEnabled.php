<?php declare(strict_types=1);

namespace App\Domains\User\Exception;

class NotEnabled extends ExceptionAbstract
{
    /**
     * @var int
     */
    protected $code = 403;

    /**
     * @var ?string
     */
    protected ?string $status = 'user-not-enabled';
}
