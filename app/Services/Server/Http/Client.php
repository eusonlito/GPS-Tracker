<?php declare(strict_types=1);

namespace App\Services\Server\Http;

use Closure;
use stdClass;
use Throwable;
use App\Services\Protocol\Resource\ResourceAbstract;

class Client
{
    /**
     * @return self
     */
    public static function new(): self
    {
        return new static(...func_get_args());
    }

    /**
     * @param \stdClass $client
     * @param \Closure $handler
     *
     * @return self
     */
    public function __construct(protected stdClass $client, protected Closure $handler)
    {
    }

    /**
     * @return void
     */
    public function handle(): void
    {
        if ($buffer = $this->readBuffer()) {
            $this->handleBuffer($buffer);
        }

        $this->close();
    }

    /**
     * @param string $buffer
     *
     * @return void
     */
    protected function handleBuffer(string $buffer): void
    {
        foreach ($this->readHandle($buffer) as $resource) {
            $this->readResource($resource);
        }
    }

    /**
     * @return ?string
     */
    protected function readBuffer(): ?string
    {
        if ($this->isSocket() === false) {
            return null;
        }

        if (($buffer = fread($this->client->socket, 1024)) === false) {
            return null;
        }

        return trim($buffer);
    }

    /**
     * @param string $buffer
     *
     * @return array
     */
    protected function readHandle(string $buffer): array
    {
        $this->client->timestamp = time();

        try {
            return ($this->handler)($buffer);
        } catch (Throwable $e) {
            $this->error($e);
        }

        return [];
    }

    /**
     * @param \App\Services\Protocol\Resource\ResourceAbstract $resource
     *
     * @return void
     */
    protected function readResource(ResourceAbstract $resource): void
    {
        $this->readResourceResponse($resource);
    }

    /**
     * @param \App\Services\Protocol\Resource\ResourceAbstract $resource
     *
     * @return void
     */
    protected function readResourceResponse(ResourceAbstract $resource): void
    {
        fwrite($this->client->socket, $resource->response());
    }

    /**
     * @return bool
     */
    protected function isSocket(): bool
    {
        return is_resource($this->client->socket);
    }

    /**
     * @return void
     */
    protected function close(): void
    {
        if ($this->isSocket()) {
            try {
                fclose($this->client->socket);
            } catch (Throwable $e) {
                $this->error($e);
            }
        }

        $this->client->socket = null;
    }

    /**
     * @param \Throwable $e
     *
     * @return void
     */
    protected function error(Throwable $e): void
    {
        if ($this->errorIsReportable($e)) {
            report($e);
        }
    }

    /**
     * @param \Throwable $e
     *
     * @return bool
     */
    protected function errorIsReportable(Throwable $e): bool
    {
        return str_contains($e->getMessage(), ' closed ') === false;
    }
}
