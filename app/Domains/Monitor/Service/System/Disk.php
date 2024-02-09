<?php declare(strict_types=1);

namespace App\Domains\Monitor\Service\System;

class Disk
{
    /**
     * @var int
     */
    protected int $disk;

    /**
     * @var int
     */
    protected int $diskLoad;

    /**
     * @var int
     */
    protected int $diskFree;

    /**
     * @var int
     */
    protected int $diskPercent;

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
        $this->disk();
        $this->apps();
    }

    /**
     * @return void
     */
    protected function disk(): void
    {
        $this->disk = intval(shell_exec('df . | awk \'NR==2{print $2}\'')) * 1024;
        $this->diskLoad = intval(shell_exec('df . | awk \'NR==2{print $3}\'')) * 1024;
        $this->diskFree = $this->disk - $this->diskLoad;
        $this->diskPercent = intval(round($this->diskLoad / $this->disk * 100));
    }

    /**
     * @return array
     */
    public function get(): array
    {
        return [
            'disk' => $this->disk,
            'disk_load' => $this->diskLoad,
            'disk_free' => $this->diskFree,
            'disk_percent' => $this->diskPercent,
            'disk_apps' => $this->apps,
        ];
    }

    /**
     * @return void
     */
    protected function apps(): void
    {
        $this->apps = $this->sort($this->acum($this->lines($this->df())));
    }

    /**
     * @return string
     */
    protected function df(): string
    {
        return shell_exec('df | grep -v tmpfs');
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

        $apps = [];

        foreach ($lines as $line) {
            $parts = explode(' ', trim(preg_replace('/\s+/', ' ', $line)), 6);

            if (count($parts) !== 6) {
                continue;
            }

            $apps[] = [
                'dev' => $parts[0],
                'size' => intval($parts[1]) * 1024,
                'load' => intval($parts[2]) * 1024,
                'free' => intval($parts[3]) * 1024,
                'percent' => intval($parts[4]),
                'mount' => $parts[5],
            ];
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
}
