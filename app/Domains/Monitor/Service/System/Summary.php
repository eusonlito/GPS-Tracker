<?php declare(strict_types=1);

namespace App\Domains\Monitor\Service\System;

class Summary extends SystemAbstract
{
    /**
     * @var string
     */
    protected string $uptime;

    /**
     * @var string
     */
    protected string $tasks;

    /**
     * @var string
     */
    protected string $cpus;

    /**
     * @var string
     */
    protected string $memory;

    /**
     * @var string
     */
    protected string $swap;

    /**
     * @return self
     */
    public function __construct()
    {
        $this->load();
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
            'uptime' => $this->uptime,
            'tasks' => $this->tasks,
            'cpus' => $this->cpus,
            'memory' => $this->memory,
            'swap' => $this->swap,
        ];
    }

    /**
     * @return bool
     */
    protected function isAvailable(): bool
    {
        return isset(
            $this->uptime,
            $this->tasks,
            $this->cpus,
            $this->memory,
            $this->swap,
        );
    }

    /**
     * @return void
     */
    protected function load(): void
    {
        $info = array_slice($this->top(), 0, 5);

        if (isset($info[0], $info[1], $info[2], $info[3], $info[4]) === false) {
            return;
        }

        $this->uptime = implode(' ', array_slice($info[0], 2));
        $this->tasks = implode(' ', $info[1]);
        $this->cpus = implode(' ', $info[2]);
        $this->memory = implode(' ', $info[3]);
        $this->swap = implode(' ', $info[4]);
    }
}
