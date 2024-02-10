<?php declare(strict_types=1);

namespace App\Domains\Monitor\Service\System;

abstract class SystemAbstract
{
    /**
     * @param string $command
     *
     * @return string
     */
    protected function cmd(string $command): string
    {
        return trim(shell_exec($command));
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
}
