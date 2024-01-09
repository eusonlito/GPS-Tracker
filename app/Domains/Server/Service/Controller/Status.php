<?php declare(strict_types=1);

namespace App\Domains\Server\Service\Controller;

use stdClass;
use Illuminate\Support\Collection as CollectionGeneric;
use App\Domains\Server\Model\Server as Model;
use App\Domains\Server\Model\Collection\Server as Collection;
use App\Services\Server\Process as ServerProcess;

class Status extends ControllerAbstract
{
    /**
     * @return array
     */
    public function data(): array
    {
        return [
            'list' => $this->list(),
            'process' => $this->process(),
        ];
    }

    /**
     * @return \App\Domains\Server\Model\Collection\Server
     */
    protected function list(): Collection
    {
        return Model::query()->list()->get();
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    protected function process(): CollectionGeneric
    {
        return ServerProcess::new()
            ->list()
            ->map($this->processMap(...));
    }

    /**
     * @param \stdClass $process
     *
     * @return \stdClass
     */
    protected function processMap(stdClass $process): stdClass
    {
        $process->log = $this->processMapLog($process);

        return $process;
    }

    /**
     * @param \stdClass $process
     *
     * @return ?string
     */
    protected function processMapLog(stdClass $process): ?string
    {
        $prefix = 'server/'.date('Y/m/d');
        $base = storage_path('logs/'.$prefix);
        $port = $process->port;

        if (is_file($base.'/'.$port.'.log')) {
            $path = $prefix.'/'.$port.'.log';
        } elseif (is_file($base.'/'.$port.'-debug.log')) {
            $path = $prefix.'/'.$port.'-debug.log';
        } elseif (is_file($base.'/'.$port.'-connection.log')) {
            $path = $prefix.'/'.$port.'-connection.log';
        } elseif (is_dir($base)) {
            $path = $prefix;
        } else {
            return null;
        }

        return base64_encode($path);
    }
}
