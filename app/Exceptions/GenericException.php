<?php declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Throwable;

class GenericException extends Exception
{
    /**
     * @var string
     */
    protected string $status = '';

    /**
     * @param ?string $message = null
     * @param ?int $code = 0
     * @param ?\Throwable $previous = null
     * @param ?string $status = null
     *
     * @return self
     */
    public function __construct(?string $message = null, ?int $code = 0, ?Throwable $previous = null, ?string $status = null)
    {
        $this->setStatus((string)$status);

        parent::__construct((string)$message, $code ?: $this->code, $previous);
    }

    /**
     * @param string $status
     *
     * @return void
     */
    final public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    /**
     * @return string
     */
    final public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param int $code
     *
     * @return void
     */
    final public function setStatusCode(int $code): void
    {
        $this->code = $code;
    }

    /**
     * @return int
     */
    final public function getStatusCode(): int
    {
        return $this->code;
    }
}
