<?php declare(strict_types=1);

namespace App\Domains\Monitor\Service\System;

use App\Services\Command\Exec;

class Cpu extends SystemAbstract
{
    /**
     * @var int
     */
    protected int $cores;

    /**
     * @var array
     */
    protected array $average;

    /**
     * @var float
     */
    protected float $load;

    /**
     * @var float
     */
    protected float $free;

    /**
     * @var float
     */
    protected float $percent;

    /**
     * @var array
     */
    protected array $apps;

    /**
     * @return self
     */
    public function __construct()
    {
        $this->load();
        $this->apps();
    }

    /**
     * @return ?array
     */
    public function get(): ?array
    {
        if ($this->isAvailable() === false) {
            return null;
        }

        return [
            'cores' => $this->cores,
            'average' => $this->average,
            'load' => $this->load,
            'free' => $this->free,
            'percent' => $this->percent,
            'apps' => $this->apps,
        ];
    }

    /**
     * @return bool
     */
    protected function isAvailable(): bool
    {
        return isset(
            $this->cores,
            $this->average,
            $this->load,
            $this->free,
            $this->percent,
            $this->apps,
        );
    }

    /**
     * @return void
     */
    protected function load(): void
    {
        $this->cores = Exec::cmdInt('nproc --all');

        if (empty($this->cores)) {
            return;
        }

        $info = Exec::cmdArray('cat /proc/loadavg');

        if (isset($info[0], $info[1], $info[2]) === false) {
            return;
        }

        $this->average = array_slice($info, 0, 3);
        $this->load = floatval($info[0]);
        $this->free = $this->cores - $this->load;
        $this->percent = intval(round($this->load / $this->cores * 100));
    }

    /**
     * @return void
     */
    protected function apps(): void
    {
        $this->apps = $this->limit(
            $this->sort(
                $this->summary(
                    $this->acum(
                        array_slice($this->top(), 7)
                    )
                )
            )
        );
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
            $memory = $this->memorySize($line[5]);

            if (intval($memory) === 0) {
                continue;
            }

            $app = trim($line[11]);

            if ($app === 'top') {
                continue;
            }

            if (empty($apps[$app])) {
                $apps[$app] = [
                    'app' => $app,
                    'memory' => $memory,
                    'count' => 0,
                    'percent' => 0,
                ];
            }

            $apps[$app]['percent'] += floatval(str_replace(',', '.', $line[8]));
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
        foreach ($apps as $index => $app) {
            $app[$index]['percent'] = round($app['percent'] / $app['count'], 2);
        }

        return $apps;
    }

    /**
     * @param array $apps
     *
     * @return array
     */
    protected function sort(array $apps): array
    {
        usort($apps, static fn ($a, $b) => ($b['percent'] <=> $a['percent']) ?: ($b['memory'] <=> $a['memory']));

        return $apps;
    }

    /**
     * @param array $apps
     *
     * @return array
     */
    protected function limit(array $apps): array
    {
        return array_slice($apps, 0, 10);
    }
}
