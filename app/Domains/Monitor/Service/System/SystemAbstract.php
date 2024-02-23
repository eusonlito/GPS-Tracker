<?php declare(strict_types=1);

namespace App\Domains\Monitor\Service\System;

use App\Services\Command\Exec;

abstract class SystemAbstract
{
    /**
     * @return self
     */
    public static function new(): self
    {
        return new static(...func_get_args());
    }

    /**
     * @param string $size
     *
     * @return int
     */
    protected function memorySize(string $size): int
    {
        if ($size === '0') {
            return 0;
        }

        if (is_numeric($size)) {
            return intval($size * 1024);
        }

        $unit = substr($size, -1);
        $size = floatval(substr(str_replace(',', '.', $size), 0, -1)) * 1024;

        return match ($unit) {
            'm' => intval($size * 1024),
            'g' => intval($size * 1024 * 1024),
            't' => intval($size * 1024 * 1024 * 1024),
            'p' => intval($size * 1024 * 1024 * 1024),
            default => intval($size),
        };
    }

    /**
     * @return array
     */
    protected function top(): array
    {
        static $cache;

        return $cache ??= Exec::cmdLinesArray('top -b -w 512 -n 1');
    }
}
