<?php declare(strict_types=1);

namespace App\Services\Html;

use Throwable;
use Illuminate\Http\Request;
use App\Services\Request\Response;

class Alert
{
    /**
     * @const int
     */
    protected const TRACE = 10;

    /**
     * @param string $message
     *
     * @return bool
     */
    public static function success(string $message): bool
    {
        static::setMessage(__FUNCTION__, $message);

        return true;
    }

    /**
     * @param string $message
     *
     * @return bool
     */
    public static function error(string $message): bool
    {
        static::setMessage(__FUNCTION__, $message);

        return false;
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \Throwable $e
     *
     * @throws \Exception
     *
     * @return bool
     */
    public static function exception(Request $request, Throwable $e): bool
    {
        if (helper()->isExceptionSystem($e)) {
            report($e);
        }

        if ($request->ajax() || $request->wantsJson()) {
            throw $e;
        }

        $message = static::messageFromException($e);

        if (config('app.debug')) {
            $message = static::debug($e, $message);
        } else {
            $message = static::messageFix($message);
        }

        Response::status(intval(method_exists($e, 'getStatusCode') ? $e->getStatusCode() : $e->getCode()));

        return static::error($message);
    }

    /**
     * @param \Throwable $e
     * @param string $message
     *
     * @return string
     */
    protected static function debug(Throwable $e, string $message): string
    {
        $base = base_path();
        $trace = ['['.str_replace($base, '', $e->getFile()).' - '.$e->getLine().'] '.$message];

        foreach ($e->getTrace() as $line) {
            if (empty($line['file']) || str_contains($line['file'], '/vendor/')) {
                continue;
            }

            $trace[] = '» '.str_replace($base, '', $line['file']).' - '.$line['line'];

            if (count($trace) === static::TRACE) {
                break;
            }
        }

        return implode("\n<br />", $trace);
    }

    /**
     * @param \Throwable $e
     *
     * @return string
     */
    protected static function messageFromException(Throwable $e): string
    {
        $message = $e->getMessage();

        if (str_starts_with($message, '{') === false) {
            return $message;
        }

        if (empty($json = json_decode($message, true))) {
            return $message;
        }

        if (isset($json['message'])) {
            return $json['message'];
        }

        return json_encode(array_values($json));
    }

    /**
     * @param string $message
     *
     * @return string
     */
    protected static function messageFix(string $message): string
    {
        if (str_contains($message, 'SQLSTATE') === false) {
            return $message;
        }

        return __('error.generic');
    }

    /**
     * @param string $status
     * @param string $message
     *
     * @return void
     */
    protected static function setMessage(string $status, string $message)
    {
        service()->message()->$status($message);
    }
}
