<?php declare(strict_types=1);

namespace App\Domains\Monitor\Service\System;

class CpuMemory extends SystemAbstract
{
    /**
     * @var int
     */
    protected int $cpu;

    /**
     * @var array
     */
    protected array $cpuAvg;

    /**
     * @var float
     */
    protected float $cpuLoad;

    /**
     * @var float
     */
    protected float $cpuFree;

    /**
     * @var int
     */
    protected int $cpuPercent;

    /**
     * @var int
     */
    protected int $memory;

    /**
     * @var int
     */
    protected int $memoryLoad;

    /**
     * @var int
     */
    protected int $memoryFree;

    /**
     * @var int
     */
    protected int $memoryPercent;

    /**
     * @var array
     */
    protected array $apps;

    /**
     * @return self
     */
    public static function new(): self
    {
        return new static(...func_get_args());
    }

    /**
     * @return self
     */
    public function __construct()
    {
        $this->cpu();
        $this->memory();
        $this->apps();
    }

    /**
     * @return void
     */
    protected function cpu(): void
    {
        $info = array_map('floatval', $this->cmdArray('cat /proc/loadavg'));

        $this->cpu = $this->cmdInt('nproc');
        $this->cpuAvg = array_slice($info, 0, 3);
        $this->cpuLoad = $info[0];
        $this->cpuFree = $this->cpu - $this->cpuLoad;
        $this->cpuPercent = intval(round($this->cpuLoad / $this->cpu * 100));
    }

    /**
     * @return void
     */
    protected function memory(): void
    {
        $info = array_map('intval', $this->cmdArray('free -b | grep "Mem:"'));

        $this->memory = $info[1];
        $this->memoryLoad = $info[2];
        $this->memoryFree = $info[6];
        $this->memoryPercent = intval(round($this->memoryLoad / $this->memory * 100));
    }

    /**
     * @return void
     */
    protected function apps(): void
    {
        $this->apps = $this->group($this->summary($this->acum($this->lines($this->ps()))));
    }

    /**
     * @return array
     */
    public function get(): array
    {
        return [
            'cpu' => $this->cpu,
            'cpu_avg' => $this->cpuAvg,
            'cpu_load' => $this->cpuLoad,
            'cpu_free' => $this->cpuFree,
            'cpu_percent' => $this->cpuPercent,
            'cpu_apps' => $this->apps['cpu'],
            'memory' => $this->memory,
            'memory_load' => $this->memoryLoad,
            'memory_free' => $this->memoryFree,
            'memory_percent' => $this->memoryPercent,
            'memory_apps' => $this->apps['memory'],
        ];
    }

    /**
     * @return string
     */
    protected function ps(): string
    {
        return $this->cmd('ps --no-headers -eo pid,ppid,rss,pcpu,comm:50,cmd:50');
    }

    /**
     * @param string $output
     *
     * @return array
     */
    protected function lines(string $output): array
    {
        return array_filter(explode("\n", $output));
    }

    /**
     * @param array $lines
     *
     * @return array
     */
    protected function acum(array $lines): array
    {
        $apps = [];

        foreach ($lines as $line) {
            $parts = explode(' ', trim(preg_replace('/\s+/', ' ', $line)), 6);

            if (count($parts) !== 6) {
                continue;
            }

            $pid = intval($parts[0]);
            $ppid = intval($parts[1]);

            if (($pid === 0) || ($ppid === 0) || ($ppid === 2)) {
                continue;
            }

            $app = trim($parts[4]);

            if ($app === 'ps') {
                continue;
            }

            if (empty($apps[$app])) {
                $apps[$app] = [
                    'ppid' => $ppid,
                    'pid' => $pid,
                    'app' => $app,
                    'count' => 0,
                    'memory' => 0,
                    'cpu' => 0,
                ];
            }

            $apps[$app]['memory'] += intval($parts[2]);
            $apps[$app]['cpu'] += floatval($parts[3]);
            $apps[$app]['count']++;
        }

        return $apps;
    }

    /**
     * @param array $apps
     *
     * @return array
     */
    protected function summary(array $apps): array
    {
        return array_map(function ($app) {
            $app['memory'] *= 1024;
            $app['memory_percent'] = round($app['memory'] * 100 / $this->memory);
            $app['cpu_percent'] = $app['cpu'];

            return $app;
        }, $apps);
    }

    /**
     * @param array $apps
     *
     * @return array
     */
    protected function group(array $apps): array
    {
        $groups = [];

        foreach (['memory', 'cpu'] as $group) {
            $groups[$group] = $this->groupApps($apps, $group);
        }

        return $groups;
    }

    /**
     * @param array $apps
     * @param string $group
     *
     * @return array
     */
    protected function groupApps(array $apps, string $group): array
    {
        return $this->groupAppsLimit($this->groupAppsSort($apps, $group));
    }

    /**
     * @param array $apps
     * @param string $group
     *
     * @return array
     */
    protected function groupAppsSort(array $apps, string $group): array
    {
        usort($apps, static fn ($a, $b) => $b[$group] <=> $a[$group]);

        return $apps;
    }

    /**
     * @param array $apps
     *
     * @return array
     */
    protected function groupAppsLimit(array $apps): array
    {
        return array_slice($apps, 0, 10);
    }
}
