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
     * @return string
     */
    abstract protected static function folder(): string;

    /**
     * @return string
     */
    abstract protected static function path(): string;

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
        $name = static::folder();

        if (isset(static::$logger[$name])) {
            return static::$logger[$name];
        }

        $formatter = new LineFormatter("[%datetime%]: %message% %extra% %context%\n");
        $formatter->setMaxNormalizeDepth(10000);

        $handler = new StreamHandler(static::loggerFile());
        $handler->setFormatter($formatter);

        $logger = new Logger($name);
        $logger->pushHandler($handler);

        return static::$logger[$name] = $logger;
    }

    /**
     * @return string
     */
    protected static function loggerFile(): string
    {
        return storage_path('logs/'.static::folder().'/'.static::path().'.log');
    }
}
