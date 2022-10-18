<?php declare(strict_types=1);

namespace App\Services\Request;

use Throwable;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Services\Logger\RotatingFileAbstract;

class Logger extends RotatingFileAbstract
{
    /**
     * @var string
     */
    protected static string $name = 'requests';

    /**
     * @var array
     */
    protected static array $exclude = [
        'headers' => ['authorization', 'cookie', 'php-auth-user', 'php-auth-pw'],
        'headers-test' => ['cookie'],

        'input' => ['password'],
        'input-test' => [],
    ];

    /**
     * @var array
     */
    protected static array $excludeTest = ['cookie'];

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return void
     */
    public static function fromRequest(Request $request): void
    {
        if (config('logging.channels.request.enabled') !== true) {
            return;
        }

        static::info($request->url(), static::data($request));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \Symfony\Component\HttpFoundation\Response $response
     *
     * @return void
     */
    public static function fromRequestAndResponse(Request $request, Response $response): void
    {
        if (config('logging.channels.request.enabled') !== true) {
            return;
        }

        static::info($request->url(), static::data($request, [
            'response' => static::response($response),
        ]));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \Throwable $e
     *
     * @return void
     */
    public static function fromException(Request $request, Throwable $e): void
    {
        static::error($request->url(), static::data($request, [
            'class' => $e::class,
            'code' => static::exceptionCode($e),
            'status' => static::exceptionStatus($e),
            'message' => $e->getMessage(),
        ]));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param array $data = []
     *
     * @return array
     */
    protected static function data(Request $request, array $data = []): array
    {
        return [
            'ip' => $request->ip(),
            'method' => $request->method(),
            'headers' => static::headers($request),
            'input' => static::input($request),
            'execution_time' => (microtime(true) - (defined('LARAVEL_START') ? LARAVEL_START : 0)),
            'memory_usage' => round(memory_get_peak_usage() / 1024, 2),
        ] + $data;
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    protected static function headers(Request $request): array
    {
        return static::hidden($request->headers->all(), static::exclude('headers'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    protected static function input(Request $request): array
    {
        return static::hidden($request->input(), static::exclude('input'));
    }

    /**
     * @param \Throwable $e
     *
     * @return int
     */
    protected static function exceptionCode(Throwable $e): int
    {
        return intval(method_exists($e, 'getStatusCode') ? $e->getStatusCode() : $e->getCode());
    }

    /**
     * @param \Throwable $e
     *
     * @return ?string
     */
    protected static function exceptionStatus(Throwable $e): ?string
    {
        return method_exists($e, 'getStatus') ? $e->getStatus() : null;
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Response $response
     *
     * @return mixed
     */
    protected static function response(Response $response)
    {
        return method_exists($response, 'getData') ? $response->getData() : null;
    }

    /**
     * @param string $name
     *
     * @return array
     */
    protected static function exclude(string $name): array
    {
        return static::$exclude[$name.(config('app.test') ? '-test' : '')];
    }

    /**
     * @param array $input
     * @param array $keys
     *
     * @return array
     */
    protected static function hidden(array $input, array $keys): array
    {
        foreach (array_unique($keys) as $each) {
            if (isset($input[$each])) {
                $input[$each] = 'HIDDEN';
            }
        }

        return $input;
    }
}
