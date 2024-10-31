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
        $process->route = $this->processMapRoute($process);

        return $process;
    }

    /**
     * @param \stdClass $process
     *
     * @return ?string
     */
    protected function processMapRoute(stdClass $process): ?string
    {
        $path = 'server/'.date('Y/m/d');
        $base = storage_path('logs/'.$path);
        $route = base64_encode($path);
        $port = $process->port;

        if (is_file($base.'/'.$port.'.log')) {
            $file = $port.'.log';
        } elseif (is_file($base.'/'.$port.'-debug.log')) {
            $file = $port.'-debug.log';
        } elseif (is_file($base.'/'.$port.'-connection.log')) {
            $file = $port.'-connection.log';
        } else {
            $file = null;
        }

        if ($file) {
            return route('monitor.log.file', [$route, base64_encode($file)]);
        }

        if (is_dir($base)) {
            return route('monitor.log', $route);
        }

        return null;
    }
}
