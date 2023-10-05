<?php declare(strict_types=1);

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException as AuthenticationExceptionVendor;

class AuthenticationException extends AuthenticationExceptionVendor
{
    /**
     * @var int
     */
    protected $code = 401;
}
