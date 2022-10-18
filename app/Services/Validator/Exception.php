<?php declare(strict_types=1);

namespace App\Services\Validator;

use Throwable;

class Exception extends \Exception
{
    /**
     * @var int
     */
    protected $code = 422;

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
        parent::__construct((string)$message, $code ?: $this->code, $previous);

        $this->setStatus((string)$status);
    }

    /**
     * @param string $status
     *
     * @return void
     */
    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }
}
