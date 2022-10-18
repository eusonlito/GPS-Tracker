<?php declare(strict_types=1);

namespace App\Exceptions;

use Throwable;
use Illuminate\Auth\AuthenticationException as AuthenticationExceptionVendor;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class Response
{
    /**
     * @param \Throwable $e
     *
     * @return \App\Exceptions\GenericException
     */
    public static function fromException(Throwable $e): GenericException
    {
        if ($e instanceof GenericException) {
            $class = $e::class;
        } else {
            $class = GenericException::class;
        }

        return new $class(static::message($e), static::code($e), $e, static::status($e));
    }

    /**
     * @param \Throwable $e
     *
     * @return string
     */
    protected static function message(Throwable $e): string
    {
        if (config('app.debug')) {
            return $e->getMessage();
        }

        if ($e instanceof AuthenticationExceptionVendor) {
            return __('user-auth.error.empty');
        }

        if ($e instanceof AuthenticationException) {
            return $e->getMessage() ?: __('user-auth.error.auth');
        }

        if ($e instanceof NotFoundHttpException) {
            return $e->getMessage() ?: __('common.error.not-found');
        }

        if ($e instanceof ModelNotFoundException) {
            return $e->getMessage() ?: __('common.error.not-found-model');
        }

        if ($e instanceof MethodNotAllowedHttpException) {
            return __('common.error.method-not-allowed');
        }

        if ($e instanceof QueryException) {
            return __('common.error.query');
        }

        if (static::isExceptionSystem($e)) {
            return __('common.error.system');
        }

        return $e->getMessage();
    }

    /**
     * @param \Throwable $e
     *
     * @return int
     */
    protected static function code(Throwable $e): int
    {
        if (static::isExceptionNotFound($e)) {
            return 404;
        }

        if (static::isExceptionAuth($e)) {
            return 401;
        }

        if (method_exists($e, 'getStatusCode')) {
            $code = (int)$e->getStatusCode();
        } else {
            $code = (int)$e->getCode();
        }

        return (($code >= 400) && ($code < 600)) ? $code : 500;
    }

    /**
     * @param \Throwable $e
     *
     * @return string
     */
    protected static function status(Throwable $e): string
    {
        if (method_exists($e, 'getStatus') && ($status = $e->getStatus())) {
            return $status;
        }

        if ($e instanceof AuthenticationExceptionVendor) {
            return 'user_auth';
        }

        if ($e instanceof AuthenticationException) {
            return 'user_error';
        }

        if ($e instanceof NotFoundHttpException) {
            return 'not_found';
        }

        if ($e instanceof ModelNotFoundException) {
            return 'not_available';
        }

        if ($e instanceof MethodNotAllowedHttpException) {
            return 'method_not_allowed';
        }

        if ($e instanceof NotAllowedException) {
            return 'not_allowed';
        }

        if ($e instanceof ValidatorException) {
            return 'validator_error';
        }

        if ($e instanceof QueryException) {
            return 'query_error';
        }

        if (static::isExceptionSystem($e)) {
            return 'system_error';
        }

        return 'error';
    }

    /**
     * @param \Throwable $e
     *
     * @return bool
     */
    protected static function isExceptionNotFound(Throwable $e): bool
    {
        return ($e instanceof ModelNotFoundException)
            || ($e instanceof NotFoundHttpException);
    }

    /**
     * @param \Throwable $e
     *
     * @return bool
     */
    protected static function isExceptionAuth(Throwable $e): bool
    {
        return ($e instanceof AuthenticationExceptionVendor)
            || ($e instanceof AuthenticationException);
    }

    /**
     * @param \Throwable $e
     *
     * @return bool
     */
    protected static function isExceptionSystem(Throwable $e): bool
    {
        return helper()->isExceptionSystem($e);
    }
}
