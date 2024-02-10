<?php declare(strict_types=1);

namespace App\Domains\Monitor\Service\System;

class Memory extends SystemAbstract
{
    /**
     * @var int
     */
    protected int $size;

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
            'size' => $this->size,
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
        $info = array_map('intval', $this->cmdArray('free -b | grep "Mem:"'));

        $this->size = $info[1];
        $this->load = $info[2];
        $this->free = $info[6];
        $this->percent = intval(round($this->load / $this->size * 100));
    }

    /**
     * @return void
     */
    protected function apps(): void
    {
        $this->apps = $this->summary($this->limit($this->sort($this->acum($this->top()))));
    }

    /**
     * @return array
     */
    protected function top(): array
    {
        return $this->cmdLines('top -b -w 512 -e k -n 1 | sed -e "1,7d"');
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
            $size = $this->memorySize($line[5]);

            if ($size === 0) {
                continue;
            }

            $app = trim($line[11]);

            if (empty($apps[$app])) {
                $apps[$app] = [
                    'app' => $app,
                    'size' => 0,
                    'percent' => 0,
                ];
            }

            $apps[$app]['size'] += ($size - $this->memorySize($line[6]));
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
            $apps[$index]['percent'] = round($app['size'] * 100 / $this->size);
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
        usort($apps, static fn ($a, $b) => $b['size'] <=> $a['size']);

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
