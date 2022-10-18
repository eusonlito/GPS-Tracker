<?php declare(strict_types=1);

namespace App\Exceptions;

class AuthenticationException extends GenericException
{
    /**
     * @var int
     */
    protected $code = 401;
}
