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
        ];
    }
}
