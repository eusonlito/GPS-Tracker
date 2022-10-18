<?php declare(strict_types=1);

namespace App\Services\Request;

class Response
{
    /**
     * @var int
     */
    protected static $status = 200;

    /**
     * @param ?int $status = null
     *
     * @return int
     */
    public static function status(?int $status = null): int
    {
        if ($status !== null) {
            static::$status = static::get($status);
        }

        return static::$status;
    }

    /**
     * @param int $status
     *
     * @return int
     */
    protected static function get(int $status): int
    {
        return (($status >= 200) && ($status <= 500)) ? $status : 500;
    }
}
