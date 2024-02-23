<?php declare(strict_types=1);

namespace App\Domains\Server\Action;

use App\Services\Protocol\ProtocolAbstract;
use App\Services\Protocol\ProtocolFactory;
use App\Services\Protocol\Resource\ResourceAbstract;

class LogRead extends ActionAbstract
{
    /**
     * @var string
     */
    protected string $file;

    /**
     * @var \App\Services\Protocol\ProtocolAbstract
     */
    protected ProtocolAbstract $protocol;

    /**
     * @var array
     */
    protected array $resourceData = [];

    /**
     * @return void
     */
    public function handle(): void
    {
        $this->file();
        $this->check();
        $this->protocol();
        $this->iterate();
    }

    /**
     * @return void
     */
    protected function file(): void
    {
        $this->file = base_path($this->data['file']);
    }

    /**
     * @return void
     */
    protected function check(): void
    {
        $this->checkFile();
    }

    /**
     * @return void
     */
    protected function checkFile(): void
    {
        if (is_file($this->file) === false) {
            $this->exceptionNotFound(__('server-log-read.error.file-not-found'));
        }
    }

    /**
     * @return void
     */
    protected function protocol(): void
    {
        $this->protocol = ProtocolFactory::get($this->data['protocol']);
    }

    /**
     * @return void
     */
    protected function iterate(): void
    {
        foreach (file($this->file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
            if (count($line = explode(' ', trim($line), 2)) === 2) {
                $this->store($line[1]);
            }
        }
    }

    /**
     * @param string $body
     *
     * @return void
     */
    protected function store(string $body): void
    {
        foreach ($this->protocol->resources($body, $this->resourceData) as $resource) {
            $this->save($resource);
        }
    }

    /**
     * @param \App\Services\Protocol\Resource\ResourceAbstract $resource
     *
     * @return void
     */
    protected function save(ResourceAbstract $resource): void
    {
        if ($resource->format() === 'location') {
            $this->factory('Position')->action($this->saveData($resource))->create();
        }

        if ($data = $resource->data()) {
            $this->resourceData = $data;
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
