<?php declare(strict_types=1);

namespace App\Domains\User\Exception;

use App\Exceptions\AuthenticationException;

class AuthFailed extends AuthenticationException
{
    /**
     * @var int
     */
    protected $code = 401;

    /**
     * @var ?string
     */
    protected ?string $status = 'user-auth-failed';
}
