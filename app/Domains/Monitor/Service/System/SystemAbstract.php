<?php declare(strict_types=1);

namespace App\Domains\Monitor\Service\System;

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
     * @param string $command
     *
     * @return string
     */
    protected function cmd(string $command): string
    {
        return trim(strval(shell_exec($command)));
    }

    /**
     * @param string $command
     *
     * @return array
     */
    protected function cmdArray(string $command): array
    {
        return explode(' ', preg_replace('/\s+/', ' ', $this->cmd($command)));
    }

    /**
     * @param string $command
     *
     * @return float
     */
    protected function cmdFloat(string $command): float
    {
        return intval($this->cmd($command));
    }

    /**
     * @param string $command
     *
     * @return int
     */
    protected function cmdInt(string $command): int
    {
        return intval($this->cmd($command));
    }

    /**
     * @param string $command
     *
     * @return array
     */
    protected function cmdLines(string $command): array
    {
        return array_values(array_filter(array_map(function ($line) {
            return explode(' ', trim(preg_replace('/\s+/', ' ', $line)));
        }, explode("\n", $this->cmd($command)))));
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

        return $cache ??= $this->cmdLines('top -b -w 512 -E g -e k -n 1');
    }
}
