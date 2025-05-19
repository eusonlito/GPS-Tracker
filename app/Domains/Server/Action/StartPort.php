<?php declare(strict_types=1);

namespace App\Domains\Server\Action;

use App\Domains\Server\Model\Server as Model;
use App\Domains\Server\Exception\PortBusy as PortBusyException;
use App\Domains\Server\Exception\PortLocked as PortLockedException;
use App\Services\Filesystem\Directory;
use App\Services\Protocol\ProtocolAbstract;
use App\Services\Protocol\ProtocolFactory;
use App\Services\Protocol\Resource\ResourceAbstract;
use App\Services\Server\ServerAbstract;

class StartPort extends ActionAbstract
{
    /**
     * @var \App\Services\Protocol\ProtocolAbstract
     */
    protected ProtocolAbstract $protocol;

    /**
     * @var \App\Services\Server\ServerAbstract
     */
    protected ServerAbstract $server;

    /**
     * @return void
     */
    public function handle(): void
    {
        $this->row();
        $this->data();
        $this->protocol();

        if ($this->runningUnitTests()) {
            return;
        }

        $this->server();
        $this->kill();

        if ($this->isBusy()) {
            $this->isBusyError();

            return;
        }

        $this->serve();
    }

    /**
     * @return void
     */
    protected function row(): void
    {
        $this->row = Model::query()->byPort($this->data['port'])->firstOrFail();
    }

    /**
     * @return void
     */
    protected function data(): void
    {
        $this->dataDebug();
    }

    /**
     * @return void
     */
    protected function dataDebug(): void
    {
        $this->data['debug'] = $this->data['debug'] || $this->row->debug;
    }

    /**
     * @return void
     */
    protected function protocol(): void
    {
        $this->protocol = ProtocolFactory::get($this->row->protocol);
    }

    /**
     * @return void
     */
    protected function server(): void
    {
        $this->server = $this->protocol
            ->server($this->row->port)
            ->debug($this->data['debug']);
    }

    /**
     * @return void
     */
    protected function kill(): void
    {
        if ($this->data['reset']) {
            $this->killByReset();
        } elseif ($this->server->isLocked()) {
            $this->killByLocked();
        }
    }

    /**
     * @return void
     */
    protected function killByReset(): void
    {
        $this->server->kill();
    }

    /**
     * @return void
     */
    protected function killByLocked(): void
    {
        logger()->error(new PortLockedException(__('server.error.port-locked', ['port' => $this->data['port']])));

        $this->server->kill();
    }

    /**
     * @return bool
     */
    protected function isBusy(): bool
    {
        return $this->server->isBusy();
    }

    /**
     * @return void
     */
    protected function isBusyError(): void
    {
        if ($this->data['reset']) {
            logger()->error(new PortBusyException(__('server.error.port-busy', ['port' => $this->data['port']])));
        }
    }

    /**
     * @return void
     */
    protected function serve(): void
    {
        $this->server->accept($this->store(...));
    }

    /**
     * @param string $message
     * @param array $data = []
     *
     * @return array
     */
    protected function store(string $message, array $data = []): array
    {
        $this->logDebug($message);

        $resources = $this->protocol->resources($message, $data);

        if (empty($resources)) {
            return [];
        }

        $this->log($message);

        foreach ($resources as $resource) {
            $this->save($resource);
        }

        return $resources;
    }

    /**
     * @param \App\Services\Protocol\Resource\ResourceAbstract $resource
     *
     * @return void
     */
    protected function save(ResourceAbstract $resource): void
    {
        $this->logDebug($resource->toJson());

        if ($resource->format() === 'location') {
            $this->factory('Position')->action($this->saveData($resource))->create();
        }
    }

    /**
     * @param \App\Services\Protocol\Resource\ResourceAbstract $resource
     *
     * @return array
     */
    protected function saveData(ResourceAbstract $resource): array
    {
        return [
            'serial' => $resource->serial(),
            'latitude' => $resource->latitude(),
            'longitude' => $resource->longitude(),
            'speed' => $resource->speed(),
            'direction' => $resource->direction(),
            'signal' => $resource->signal(),
            'date_utc_at' => $resource->datetime(),
            'timezone' => $resource->timezone(),

            'debug' => $this->data['debug'],
        ];
    }

    /**
     * @param string $message
     *
     * @return void
     */
    protected function logDebug(string $message): void
    {
        if ($this->data['debug']) {
            $this->log($message, '-debug');
        }
    }

    /**
     * @param string $message
     * @param string $suffix = ''
     *
     * @return void
     */
    protected function log(string $message, string $suffix = ''): void
    {
        $file = $this->logFile($suffix);

        Directory::create($file, true);

        file_put_contents($file, $this->logContent($message), LOCK_EX | FILE_APPEND);
    }

    /**
     * @param string $suffix = ''
     *
     * @return string
     */
    protected function logFile(string $suffix = ''): string
    {
        return base_path('storage/logs/server/'.date('Y/m/d').'/'.$this->row->port.$suffix.'.log');
    }

    /**
     * @param string $message
     *
     * @return string
     */
    protected function logContent(string $message): string
    {
        return '['.date('c').'] '.$message."\n";
    }
}
