<?php declare(strict_types=1);

namespace App\Services\Buffer;

class Bit
{
    /**
     * @param int $number
     * @param int $index
     *
     * @return bool
     */
    public static function check(int $number, int $index): bool
    {
        return ($number & (1 << $index)) !== 0;
    }

    /**
     * @param int $number
     * @param int $from
     * @param int $to
     *
     * @return int
     */
    public static function between(int $number, int $from, int $to): int
    {
        return ($number >> $from) & ((1 << ($to - $from)) - 1);
    }

    /**
     * @param int $number
     * @param int $to
     *
     * @return int
     */
    public static function to(int $number, int $to): int
    {
        return static::between($number, 0, $to);
    }
}
