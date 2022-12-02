<?php declare(strict_types=1);

namespace App\Services\Helper\Traits;

use Error;
use ErrorException;
use LogicException;
use RuntimeException;
use Throwable;
use App\Exceptions\NotFoundException;

trait Exception
{
    /**
     * @param string $message = ''
     * @param string $code = ''
     *
     * @throws \App\Exceptions\NotFoundException
     *
     * @return void
     */
    public function notFound(string $message = '', string $code = ''): void
    {
        throw new NotFoundException($message ?: __('common.error.not-found'), 404, null, $code);
    }

    /**
     * @param \Throwable $e
     *
     * @return bool
     */
    public function isExceptionSystem(Throwable $e): bool
    {
        return ($e instanceof Error)
            || ($e instanceof ErrorException)
            || ($e instanceof LogicException)
            || ($e instanceof RuntimeException);
    }
}
