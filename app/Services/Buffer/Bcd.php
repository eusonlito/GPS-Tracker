<?php declare(strict_types=1);

namespace App\Services\Buffer;

class Bcd
{
    /**
     * @param string $bcd
     *
     * @return int
     */
    public static function readInteger(string $bcd): int
    {
        $int = 0;
        $length = strlen($bcd);

        for ($i = 0; $i < $length; $i++) {
            $int = $int * 10 + hexdec($bcd[$i]);
        }

        return $int;
    }
}
