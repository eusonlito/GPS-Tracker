<?php declare(strict_types=1);

namespace App\Domains\Server\Action;

use App\Domains\Server\Model\Server as Model;
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
        $this->server();
        $this->kill();

        if ($this->isBusy()) {
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
        $this->server = $this->protocol->server($this->row->port);
    }

    /**
     * @return void
     */
    protected function kill(): void
    {
        if ($this->data['reset']) {
            $this->server->kill();
        }
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
    protected function serve(): void
    {
        $this->server->accept($this->store(...));
    }

    /**
     * @param string $body
     *
     * @return array
     */
    protected function store(string $body): array
    {
        $this->logDebug($body);

        $resources = $this->protocol->resources($body);

        if (empty($resources)) {
            return [];
        }

        foreach ($resources as $resource) {
            $this->save($resource);
        }

        return $resources;
    }

    /**
     * @param string $body
     *
     * @return string
     */
    protected function logContent(string $body): string
    {
        return '['.date('c').'] '.$body."\n";
    }

    /**
     * @param \App\Services\Protocol\Resource\ResourceAbstract $resource
     *
     * @return void
     */
    protected function save(ResourceAbstract $resource): void
    {
        $this->log($resource->body());

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
        ];
    }

    /**
     * @param string $body
     *
     * @return void
     */
    protected function logDebug(string $body): void
    {
        if ($this->data['debug']) {
            $this->log($body, '-debug');
        }
    }

    /**
     * @param string $body
     * @param string $suffix = ''
     *
     * @return void
     */
    protected function log(string $body, string $suffix = ''): void
    {
        $file = $this->logFile($suffix);

        Directory::create($file, true);

        file_put_contents($file, $this->logContent($body), LOCK_EX | FILE_APPEND);
    }

    /**
     * @param string $suffix = ''
     *
     * @return string
     */
    protected function logFile(string $suffix = ''): string
    {
        return base_path('storage/logs/server/'.date('Y-m-d').'/'.$this->row->port.$suffix.'.log');
    }
}
