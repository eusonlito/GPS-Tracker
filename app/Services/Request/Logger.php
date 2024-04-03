<?php declare(strict_types=1);

namespace App\Services\Request;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Services\Logger\RotatingFileAbstract;

class Logger extends RotatingFileAbstract
{
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
     * @return string
     */
    protected static function folder(): string
    {
        return 'requests';
    }

    /**
     * @return string
     */
    protected static function path(): string
    {
        return date('Y/m/Y-m-d');
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

        $type = static::responseType($response);

        static::$type($request->url(), static::data($request, [
            'response' => static::response($response),
            'status' => $response->getStatusCode(),
        ]));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param array $data = []
     *
     * @psalm-suppress UndefinedConstant
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
            'execution_time' => sprintf('%.3f', microtime(true) - LARAVEL_START),
            'memory_usage' => round(memory_get_peak_usage(false) / 1024 / 1024, 2),
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
     * @param \Symfony\Component\HttpFoundation\Response $response
     *
     * @return string
     */
    protected static function responseType(Response $response): string
    {
        return match (substr(strval($response->getStatusCode()), 0, 1)) {
            '1', '2', '3' => 'info',
            default => 'error',
        };
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Response $response
     *
     * @return mixed
     */
    protected static function response(Response $response): mixed
    {
        return method_exists($response, 'getData')
            ? $response->getData()
            : $response->getContent();
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
