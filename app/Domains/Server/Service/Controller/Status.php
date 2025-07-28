<?php declare(strict_types=1);

namespace App\Domains\Server\Service\Controller;

use stdClass;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Support\Collection as CollectionGeneric;
use App\Domains\Server\Model\Server as Model;
use App\Domains\Server\Model\Collection\Server as Collection;
use App\Services\Server\Process as ServerProcess;

class Status extends ControllerAbstract
{
    /**
     * @var \App\Domains\Server\Model\Collection\Server
     */
    protected Collection $list;

    /**
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Contracts\Auth\Authenticatable $auth
     *
     * @return self
     */
    public function __construct(protected Request $request, protected Authenticatable $auth)
    {
        $this->list = $this->list();
    }

    /**
     * @return \App\Domains\Server\Model\Collection\Server
     */
    protected function list(): Collection
    {
        return Model::query()->list()->get();
    }

    /**
     * @return array
     */
    public function data(): array
    {
        return [
            'list' => $this->list,
            'process' => $this->process(),
        ];
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
        $process->command = $this->processMapCommand($process);
        $process->route = $this->processMapRoute($process);
        $process->protocol = $this->processMapProtocol($process);

        return $process;
    }

    /**
     * @param \stdClass $process
     *
     * @return string
     */
    protected function processMapCommand(stdClass $process): string
    {
        return str_replace(base_path('/'), '', strval($process->command));
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
            return route('monitor.log.file', [base64_encode($path), base64_encode($file)]);
        }

        if (is_dir($base)) {
            return route('monitor.log.path', base64_encode($path));
        }

        return null;
    }

    /**
     * @param \stdClass $process
     *
     * @return ?string
     */
    protected function processMapProtocol(stdClass $process): ?string
    {
        return $this->list->firstWhere('port', $process->port)?->protocol;
    }
}
