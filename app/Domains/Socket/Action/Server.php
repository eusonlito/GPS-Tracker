<?php declare(strict_types=1);

namespace App\Domains\Socket\Action;

use App\Services\Filesystem\Directory;
use App\Services\Protocol\ProtocolAbstract;
use App\Services\Protocol\ProtocolFactory;
use App\Services\Protocol\Resource\ResourceAbstract;
use App\Services\SocketWeb\Server as SocketWebServer;

class Server extends ActionAbstract
{
    /**
     * @var bool
     */
    protected bool $debug;

    /**
     * @var \App\Services\Protocol\ProtocolAbstract
     */
    protected ProtocolAbstract $protocol;

    /**
     * @var \App\Services\SocketWeb\Server
     */
    protected SocketWebServer $socket;

    /**
     * @return void
     */
    public function handle(): void
    {
        $this->debug();
        $this->socket();
        $this->kill();

        if ($this->isBusy()) {
            return;
        }

        $this->protocol();
        $this->serve();
    }

    /**
     * @return void
     */
    protected function debug(): void
    {
        $this->debug = app('configuration')->bool('socket_debug');
    }

    /**
     * @return void
     */
    protected function socket(): void
    {
        $this->socket = SocketWebServer::new($this->data['port']);
    }

    /**
     * @return void
     */
    protected function kill(): void
    {
        if ($this->data['reset']) {
            $this->socket->kill();
        }
    }

    /**
     * @return bool
     */
    protected function isBusy(): bool
    {
        return $this->socket->isBusy();
    }

    /**
     * @return void
     */
    protected function protocol(): void
    {
        $this->protocol = ProtocolFactory::fromPort($this->data['port']);
    }

    /**
     * @return void
     */
    protected function serve(): void
    {
        $this->socket->accept(fn (string $body) => $this->store($body));
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
     * @return void
     */
    protected function logDebug(string $body): void
    {
        if ($this->debug) {
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
        return base_path('storage/logs/socket/'.date('Y-m-d').'/'.$this->data['port'].$suffix.'.log');
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
}
