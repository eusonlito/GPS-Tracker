<?php declare(strict_types=1);

namespace App\Services\Logger;

use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

abstract class MonologRotatingFileAbstract
{
    /**
     * @var array
     */
    protected static array $logger = [];

    /**
     * @var string
     */
    protected static string $name;

    /**
     * @param string $title
     * @param mixed $data
     *
     * @return void
     */
    public static function info(string $title, $data = []): void
    {
        static::write(__FUNCTION__, $title, $data);
    }

    /**
     * @param string $title
     * @param mixed $data
     *
     * @return void
     */
    public static function error(string $title, $data = []): void
    {
        static::write(__FUNCTION__, $title, $data);
    }

    /**
     * @param string $status
     * @param string $title
     * @param mixed $data
     *
     * @return void
     */
    protected static function write(string $status, string $title, $data = []): void
    {
        static::logger()->$status('['.strtoupper($status).'] '.$title, $data);
    }

    /**
     * @return \Monolog\Logger
     */
    public static function logger(): Logger
    {
        if (isset(static::$logger[static::$name])) {
            return static::$logger[static::$name];
        }

        $formatter = new LineFormatter("[%datetime%]: %message% %extra% %context%\n");
        $formatter->setMaxNormalizeDepth(10000);

        $handler = new StreamHandler(storage_path('logs/'.static::$name.'/'.date('Y-m-d').'.log'));
        $handler->setFormatter($formatter);

        $logger = new Logger(static::$name);
        $logger->pushHandler($handler);

        return static::$logger[static::$name] = $logger;
    }
}
