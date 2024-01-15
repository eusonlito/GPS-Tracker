<?php declare(strict_types=1);

namespace App\Services\Server\Socket;

use Closure;
use Throwable;
use App\Domains\DeviceMessage\Model\DeviceMessage as DeviceMessageModel;
use App\Services\Protocol\Resource\ResourceAbstract;
use App\Services\Server\Connection;
use App\Services\Server\Logger;

class Client
{
    /**
     * @var bool
     */
    protected bool $debug = false;

    /**
     * @return self
     */
    public static function new(): self
    {
        return new static(...func_get_args());
    }

    /**
     * @param \App\Services\Server\Connection $connection
     * @param \Closure $handler
     *
     * @return self
     */
    public function __construct(protected Connection $connection, protected Closure $handler)
    {
    }

    /**
     * @param bool $debug
     *
     * @return self
     */
    public function debug(bool $debug): self
    {
        $this->debug = $debug && $this->connection->isDebuggable();

        return $this;
    }

    /**
     * @return bool
     */
    public function handle(): bool
    {
        $buffer = $this->readBuffer();

        $this->log('READ', $buffer);

        if (empty($buffer)) {
            return false;
        }

        $resources = $this->readHandle($buffer);

        if (empty($resources)) {
            return true;
        }

        foreach ($resources as $resource) {
            $this->readResourceData($resource);
        }

        $this->readResourceResponse($resource);
        $this->readResourceMessagesRead($resource);
        $this->readResourceMessagesWrite($resource);

        return true;
    }

    /**
     * @return string|bool|null
     */
    protected function readBuffer(): string|bool|null
    {
        try {
            $buffer = socket_read($this->connection->getSocket(), 2048);
        } catch (Throwable) {
            return false;
        }

        if (empty($buffer)) {
            return null;
        }

        if ($this->readBufferIsBinary($buffer)) {
            $buffer = bin2hex($buffer);
        }

        return trim($buffer);
    }

    /**
     * @param string $buffer
     *
     * @return bool
     */
    protected function readBufferIsBinary(string $buffer): bool
    {
        return mb_check_encoding($buffer, 'UTF-8') === false;
    }

    /**
     * @param string $buffer
     *
     * @return array
     */
    protected function readHandle(string $buffer): array
    {
        $this->connection->refresh();

        try {
            return ($this->handler)($buffer, $this->connection->getData());
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
    protected function readResourceData(ResourceAbstract $resource): void
    {
        if ($data = $resource->data()) {
            $this->connection->setData($data);
        }
    }

    /**
     * @param \App\Services\Protocol\Resource\ResourceAbstract $resource
     *
     * @return void
     */
    protected function readResourceResponse(ResourceAbstract $resource): void
    {
        if (empty($response = $resource->response())) {
            return;
        }

        $this->log('WRITE', $response);

        socket_write($this->connection->getSocket(), $response, strlen($response));
    }

    /**
     * @param \App\Services\Protocol\Resource\ResourceAbstract $resource
     *
     * @return void
     */
    protected function readResourceMessagesRead(ResourceAbstract $resource): void
    {
        if (in_array($resource->format(), ['sms', 'command']) === false) {
            return;
        }

        DeviceMessageModel::query()
            ->byDeviceSerial($resource->serial())
            ->whereSentAt(true)
            ->whereResponseAt(false)
            ->withDevice()
            ->orderByCreatedAtDesc()
            ->limit(1)
            ->get()
            ->each(fn ($message) => $this->readResourceMessageRead($resource, $message));
    }

    /**
     * @param \App\Services\Protocol\Resource\ResourceAbstract $resource
     * @param \App\Domains\DeviceMessage\Model\DeviceMessage $message
     *
     * @return void
     */
    protected function readResourceMessageRead(ResourceAbstract $resource, DeviceMessageModel $message): void
    {
        $message->response = $resource->body();
        $message->response_at = date('Y-m-d H:i:s');

        $message->save();
    }

    /**
     * @param \App\Services\Protocol\Resource\ResourceAbstract $resource
     *
     * @return void
     */
    protected function readResourceMessagesWrite(ResourceAbstract $resource): void
    {
        DeviceMessageModel::query()
            ->byDeviceSerial($resource->serial())
            ->whereSentAt(false)
            ->withDevice()
            ->get()
            ->each($this->readResourceMessageWrite(...));
    }

    /**
     * @param \App\Domains\DeviceMessage\Model\DeviceMessage $message
     *
     * @return void
     */
    protected function readResourceMessageWrite(DeviceMessageModel $message): void
    {
        $message->sent_at = date('Y-m-d H:i:s');
        $message->save();

        $contents = $message->message();

        $this->log('WRITE', $contents);

        socket_write($this->connection->getSocket(), $contents, strlen($contents));
    }

    /**
     * @param \Throwable $e
     *
     * @return void
     */
    protected function error(Throwable $e): void
    {
        logger()->error($e);

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
        return (str_contains($e->getMessage(), ' closed ') === false)
            && (str_contains($e->getMessage(), ' unable to write to socket') === false)
            && (str_contains($e->getMessage(), ' reset by peer') === false);
    }

    /**
     * @param string $message
     * @param mixed $data = ''
     *
     * @return void
     */
    protected function log(string $message, mixed $data = ''): void
    {
        if ($this->debug === false) {
            return;
        }

        Logger::port($this->connection->getServerPort())->info('['.$this->connection->getId().'] ['.$message.']', $data);
    }
}
