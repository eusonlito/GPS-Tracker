<?php declare(strict_types=1);

namespace App\Domains\Monitor\Service\System;

use App\Services\Command\Exec;

class Disk extends SystemAbstract
{
    /**
     * @var int
     */
    protected int $size;

    /**
     * @var int
     */
    protected int $load;

    /**
     * @var int
     */
    protected int $free;

    /**
     * @var int
     */
    protected int $percent;

    /**
     * @var array
     */
    protected array $mounts;

    /**
     * @return self
     */
    public function __construct()
    {
        $this->load();
        $this->mounts();
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
            'mounts' => $this->mounts,
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
        );
    }

    /**
     * @return void
     */
    protected function load(): void
    {
        $info = Exec::cmdArrayInt('df . | sed 1d');

        if (isset($info[1], $info[2], $info[3], $info[4]) === false) {
            return;
        }

        $this->size = $info[1] * 1024;
        $this->load = $info[2] * 1024;
        $this->free = $info[3] * 1024;
        $this->percent = $info[4];
    }

    /**
     * @return void
     */
    protected function mounts(): void
    {
        $this->mounts = $this->sort($this->acum($this->lines($this->df())));
    }

    /**
     * @return string
     */
    protected function df(): string
    {
        return Exec::cmd('df | grep -v tmpfs');
    }

    /**
     * @param string $output
     *
     * @return array
     */
    protected function lines(string $output): array
    {
        return array_filter(explode("\n", trim($output)));
    }

    /**
     * @param array $lines
     *
     * @return array
     */
    protected function acum(array $lines): array
    {
        array_shift($lines);

        $mounts = [];

        foreach ($lines as $line) {
            $parts = explode(' ', trim(preg_replace('/\s+/', ' ', $line)), 6);

            if (count($parts) !== 6) {
                continue;
            }

            $mounts[] = [
                'dev' => $parts[0],
                'size' => intval($parts[1]) * 1024,
                'load' => intval($parts[2]) * 1024,
                'free' => intval($parts[3]) * 1024,
                'percent' => intval($parts[4]),
                'path' => $parts[5],
            ];
        }

        return $mounts;
    }

    /**
     * @param array $mounts
     *
     * @return array
     */
    protected function sort(array $mounts): array
    {
        usort($mounts, static fn ($a, $b) => $b['percent'] <=> $a['percent']);

        return $mounts;
    }
}
