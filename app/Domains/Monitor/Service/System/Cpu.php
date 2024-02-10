<?php declare(strict_types=1);

namespace App\Domains\Monitor\Service\System;

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
    public static function new(): self
    {
        return new static(...func_get_args());
    }

    /**
     * @return self
     */
    public function __construct()
    {
        $this->load();
        $this->apps();
    }

    /**
     * @return array
     */
    public function get(): array
    {
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
     * @return void
     */
    protected function load(): void
    {
        $info = array_map('floatval', $this->cmdArray('cat /proc/loadavg'));

        $this->cores = $this->cmdInt('nproc');
        $this->average = array_slice($info, 0, 3);
        $this->load = $info[0];
        $this->free = $this->cores - $this->load;
        $this->percent = intval(round($this->load / $this->cores * 100));
    }

    /**
     * @return void
     */
    protected function apps(): void
    {
        $this->apps = $this->limit($this->sort($this->summary($this->acum($this->top()))));
    }

    /**
     * @return array
     */
    protected function top(): array
    {
        return $this->cmdLines('top -b -w 512 -n 1 | sed -e "1,7d"');
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
            if (intval($line[5]) === 0) {
                continue;
            }

            $app = trim($line[11]);

            if ($app === 'top') {
                continue;
            }

            if (empty($apps[$app])) {
                $apps[$app] = [
                    'app' => $app,
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
        usort($apps, static fn ($a, $b) => $b['percent'] <=> $a['percent']);

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
