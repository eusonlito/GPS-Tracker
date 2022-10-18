<?php declare(strict_types=1);

namespace App\Exceptions;

class ValidatorException extends GenericException
{
    /**
     * @var int
     */
    protected $code = 422;
}
