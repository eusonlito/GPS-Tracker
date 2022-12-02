<?php declare(strict_types=1);

namespace App\Services\Server;

use stdClass;
use Throwable;
use Illuminate\Support\Collection;

class Process
{
    /**
     * @return self
     */
    public static function new(): self
    {
        return new static(...func_get_args());
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function list(): Collection
    {
        $list = collect();

        foreach ($this->listProcesses() as $process) {
            $list->push($this->listProcess($process));
        }

        return $list;
    }

    /**
     * @return array
     */
    protected function listProcesses(): array
    {
        return array_filter(explode("\n", $this->listExec()));
    }

    /**
     * @return string
     */
    protected function listExec(): string
    {
        return trim((string)shell_exec('ps -ef | grep -- "artisan server:start:port.*--port=" | grep -v "grep"'));
    }

    /**
     * @param string $process
     *
     * @return \stdClass
     */
    protected function listProcess(string $process): stdClass
    {
        $process = preg_split('/\s+/', $process, 8);

        preg_match('/\-\-port=([0-9]+)/', $process[7], $port);

        return (object)[
            'owner' => $process[0],
            'pid' => (int)$process[1],
            'start' => $process[4],
            'time' => $process[6],
            'command' => $process[7],
            'port' => (int)$port[1],
        ];
    }

    /**
     * @param int $port
     *
     * @return void
     */
    public function kill(int $port): void
    {
        if ($this->isBusy($port) === false) {
            return;
        }

        shell_exec('fuser -k -SIGINT '.$port.'/tcp > /dev/null 2>&1');

        $count = 0;

        while (($count < 5) && $this->isBusy($port)) {
            sleep(++$count);
        }
    }

    /**
     * @param int $port
     *
     * @return bool
     */
    public function isBusy(int $port): bool
    {
        try {
            $fp = fsockopen('0.0.0.0', $port);
        } catch (Throwable $e) {
            return false;
        }

        fclose($fp);

        return true;
    }
}
