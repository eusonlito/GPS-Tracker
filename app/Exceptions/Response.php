<?php declare(strict_types=1);

namespace App\Exceptions;

use Throwable;
use Illuminate\Auth\AuthenticationException as AuthenticationExceptionVendor;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Response
{
    /**
     * @return self
     */
    public static function new(): self
    {
        return new static(...func_get_args());
    }

    /**
     * @param \Throwable $e
     *
     * @return self
     */
    public function __construct(protected Throwable $e)
    {
    }

    /**
     * @return \App\Exceptions\GenericException
     */
    public function exception(): GenericException
    {
        $class = $this->class();

        return new $class($this->message(), $this->code(), $this->previous(), $this->status(), $this->details());
    }

    /**
     * @return string
     */
    protected function class(): string
    {
        if ($this->e instanceof GenericException) {
            return $this->e::class;
        }

        return GenericException::class;
    }

    /**
     * @return string
     */
    protected function message(): string
    {
        $message = $this->e->getMessage();

        if (config('app.debug')) {
            return $message;
        }

        if ($this->e instanceof AuthenticationException) {
            return $message ?: __('user-auth.error.auth');
        }

        if ($this->e instanceof AuthenticationExceptionVendor) {
            return __('user-auth.error.empty');
        }

        if ($this->e instanceof NotFoundHttpException) {
            return $message ?: __('common.error.not-found');
        }

        if ($this->e instanceof ModelNotFoundException) {
            return $message ?: __('common.error.not-found-model');
        }

        if ($this->e instanceof MethodNotAllowedHttpException) {
            return __('common.error.method-not-allowed');
        }

        if ($this->e instanceof QueryException) {
            return __('common.error.query');
        }

        if ($this->isExceptionSystem()) {
            return __('common.error.system');
        }

        return $message;
    }

    /**
     * @return int
     */
    protected function code(): int
    {
        if ($this->isExceptionNotFound()) {
            return 404;
        }

        if ($this->isExceptionAuth()) {
            return 401;
        }

        if (method_exists($this->e, 'getStatusCode')) {
            $code = (int)$this->e->getStatusCode();
        } else {
            $code = (int)$this->e->getCode();
        }

        return (($code >= 400) && ($code < 600)) ? $code : 500;
    }

    /**
     * @return \Throwable
     */
    protected function previous(): Throwable
    {
        return $this->e;
    }

    /**
     * @return string
     */
    protected function status(): string
    {
        if (method_exists($this->e, 'getStatus') && ($status = $this->e->getStatus())) {
            return $status;
        }

        if ($this->e instanceof AuthenticationException) {
            return 'user_error';
        }

        if ($this->e instanceof AuthenticationExceptionVendor) {
            return 'user_auth';
        }

        if ($this->e instanceof NotFoundHttpException) {
            return 'not_found';
        }

        if ($this->e instanceof ModelNotFoundException) {
            return 'not_available';
        }

        if ($this->e instanceof MethodNotAllowedHttpException) {
            return 'method_not_allowed';
        }

        if ($this->e instanceof NotAllowedException) {
            return 'not_allowed';
        }

        if ($this->e instanceof ValidatorException) {
            return 'validator_error';
        }

        if ($this->e instanceof QueryException) {
            return 'query_error';
        }

        if ($this->isExceptionSystem()) {
            return 'system_error';
        }

        return 'error';
    }

    /**
     * @return ?array
     */
    protected function details(): ?array
    {
        if (method_exists($this->e, 'getDetails')) {
            return $this->e->getDetails();
        }

        return null;
    }

    /**
     * @return bool
     */
    protected function isExceptionNotFound(): bool
    {
        return ($this->e instanceof ModelNotFoundException)
            || ($this->e instanceof NotFoundHttpException);
    }

    /**
     * @return bool
     */
    protected function isExceptionAuth(): bool
    {
        return $this->e instanceof AuthenticationExceptionVendor;
    }

    /**
     * @return bool
     */
    protected function isExceptionSystem(): bool
    {
        return helper()->isExceptionSystem($this->e);
    }
}
