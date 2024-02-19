<?php declare(strict_types=1);

namespace App\Domains\Monitor\Service\System;

use App\Services\Command\Exec;

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
            'size' => $this->size,
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
            $this->size,
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
        $info = Exec::cmdArrayInt('free -b | grep "Mem:"');

        if (isset($info[1], $info[2], $info[6]) === false) {
            return;
        }

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
        $this->apps = $this->summary(
            $this->limit(
                $this->sort(
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
