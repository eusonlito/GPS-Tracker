<?php declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Throwable;

class GenericException extends Exception
{
    /**
     * @var ?string
     */
    protected ?string $status;

    /**
     * @var ?array
     */
    protected ?array $details;

    /**
     * @param string $message = null
     * @param int $code = 0
     * @param ?\Throwable $previous = null
     * @param ?string $status = null
     * @param ?array $details = null
     *
     * @return self
     */
    public function __construct(
        string $message = '',
        int $code = 0,
        ?Throwable $previous = null,
        ?string $status = null,
        ?array $details = null
    ) {
        parent::__construct($message, $code ?: $this->code ?? 0, $previous);

        $this->setStatus($status);
        $this->setDetails($details);
    }

    /**
     * @param ?string $status
     *
     * @return void
     */
    final public function setStatus(?string $status): void
    {
        $this->status = $status;
    }

    /**
     * @return ?string
     */
    final public function getStatus(): ?string
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

    /**
     * @param ?array $details
     *
     * @return void
     */
    final public function setDetails(?array $details): void
    {
        $this->details = $details;
    }

    /**
     * @return ?array
     */
    final public function getDetails(): ?array
    {
        return $this->details;
    }
}
