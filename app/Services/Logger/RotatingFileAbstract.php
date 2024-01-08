<?php declare(strict_types=1);

namespace App\Services\Logger;

abstract class RotatingFileAbstract
{
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
     * @param mixed $data = null
     *
     * @return void
     */
    public static function info(string $title, mixed $data = null): void
    {
        static::write(__FUNCTION__, $title, $data);
    }

    /**
     * @param string $title
     * @param mixed $data = null
     *
     * @return void
     */
    public static function error(string $title, mixed $data = null): void
    {
        static::write(__FUNCTION__, $title, $data);
    }

    /**
     * @param string $status
     * @param mixed $title
     * @param mixed $data = null
     *
     * @return void
     */
    protected static function write(string $status, mixed $title, mixed $data = null): void
    {
        file_put_contents(static::file(), static::contents($status, $title, $data), FILE_APPEND | LOCK_EX);
    }

    /**
     * @return string
     */
    protected static function file(): string
    {
        $file = storage_path('logs/'.static::folder().'/'.static::path().'.log');

        clearstatcache(true, $file);

        if (is_file($file) === false) {
            helper()->mkdir($file, true);
        }

        return $file;
    }

    /**
     * @param string $status
     * @param mixed $title
     * @param mixed $data
     *
     * @return string
     */
    protected static function contents(string $status, mixed $title, mixed $data): string
    {
        return '['.static::timestamp().'] ['.strtoupper($status).'] '.static::toString($title).' '.static::toString($data)."\n";
    }

    /**
     * @return string
     */
    protected static function timestamp(): string
    {
        return date_create()->format('Y-m-d H:i:s.v P');
    }

    /**
     * @param mixed $contents
     *
     * @return string
     */
    protected static function toString(mixed $contents): string
    {
        if (is_string($contents) || is_numeric($contents)) {
            return '['.$contents.']';
        }

        return json_encode($contents, JSON_INVALID_UTF8_SUBSTITUTE | JSON_UNESCAPED_LINE_TERMINATORS | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }
}
