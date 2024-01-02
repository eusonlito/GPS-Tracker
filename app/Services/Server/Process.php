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
        return trim((string)shell_exec($this->listExecCmd()));
    }

    /**
     * @return string
     */
    protected function listExecCmd(): string
    {
        return 'export COLUMNS=256;'
            .' ps -eo pid,user,lstart,rss,pcpu,cmd'
            .' | grep -- "'.base_path().'"'
            .' | grep -- "artisan server:start:port.*--port="'
            .' | sort'
            .' | grep -v "grep"';
    }

    /**
     * @param string $process
     *
     * @return \stdClass
     */
    protected function listProcess(string $process): stdClass
    {
        $process = preg_split('/\s+/', trim($process), 10);

        preg_match('/\-\-port=([0-9]+)/', $process[9], $port);

        return (object)[
            'pid' => (int)$process[0],
            'owner' => $process[1],
            'start' => date('Y-m-d H:i:s', strtotime($process[3].' '.$process[4].' '.$process[6].' '.$process[5])),
            'memory' => round($process[7] / 1024, 2),
            'cpu' => $process[8],
            'command' => $process[9],
            'port' => (int)$port[1],
        ];
    }

    /**
     * @param int $port
     *
     * @return bool
     */
    public function kill(int $port): bool
    {
        foreach (['SIGINT', 'SIGTERM', 'SIGKILL'] as $signal) {
            if ($this->killSignal($port, $signal)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param int $port
     * @param string $signal
     *
     * @return bool
     */
    public function killSignal(int $port, string $signal): bool
    {
        if ($this->isBusy($port) === false) {
            return true;
        }

        shell_exec(sprintf('fuser -k -%s %s/tcp > /dev/null 2>&1', $signal, $port));

        sleep(1);

        return $this->isBusy($port) === false;
    }

    /**
     * @param int $port
     *
     * @return bool
     */
    public function isBusy(int $port): bool
    {
        $errno = $errstr = null;

        try {
            $fp = fsockopen('0.0.0.0', $port, $errno, $errstr, 1);
        } catch (Throwable $e) {
            return $errno !== 111;
        }

        if (is_resource($fp) === false) {
            return false;
        }

        fclose($fp);

        return true;
    }
}
