<?php declare(strict_types=1);

namespace App\Services\Socket;

use Closure;
use Socket;
use stdClass;
use Throwable;
use App\Domains\DeviceMessage\Model\DeviceMessage as DeviceMessageModel;
use App\Services\Protocol\Resource as ProtocolResource;

class Client
{
    /**
     * @param ?\App\Services\Protocol\Resource
     */
    protected ?ProtocolResource $resource;

    /**
     * @return self
     */
    public static function new(): self
    {
        return new static(...func_get_args());
    }

    /**
     * @param \stdClass &$this->client
     * @param \Closure $handler
     *
     * @return self
     */
    public function __construct(protected stdClass &$client, protected Closure $handler)
    {
    }

    /**
     * @return bool
     */
    public function handle(): bool
    {
        $buffer = $this->readBuffer();

        if ($buffer === null) {
            return false;
        }

        if (empty($buffer)) {
            return true;
        }

        $this->resource = $this->readHandle($buffer);

        if ($this->resource === null) {
            return true;
        }

        $this->readResourceResponse();
        $this->readResourceMessages();

        return true;
    }

    /**
     * @return ?string
     */
    protected function readBuffer(): ?string
    {
        if ($this->isSocket($this->client->socket) === false) {
            return null;
        }

        if (($buffer = socket_read($this->client->socket, 2048)) === null) {
            return null;
        }

        return trim($buffer);
    }

    /**
     * @param string $buffer
     *
     * @return ?\App\Services\Protocol\Resource
     */
    protected function readHandle(string $buffer): ?ProtocolResource
    {
        $this->client->timestamp = time();

        try {
            return ($this->handler)($buffer);
        } catch (Throwable $e) {
            return $this->error($e);
        }
    }

    /**
     * @return void
     */
    protected function readResourceResponse(): void
    {
        if ($response = $this->resource->response()) {
            socket_write($this->client->socket, $response, strlen($response));
        }
    }

    /**
     * @return void
     */
    protected function readResourceMessages(): void
    {
        if (empty($this->resource->serial())) {
            return;
        }

        DeviceMessageModel::byDeviceSerial($this->resource->serial())
            ->whereSentAt()
            ->get()
            ->each(fn ($message) => $this->readResourceMessage($message));
    }

    /**
     * @param \App\Domains\DeviceMessage\Model\DeviceMessage $message
     *
     * @return void
     */
    protected function readResourceMessage(DeviceMessageModel $message): void
    {
        $message->sent_at = date('Y-m-d H:i:s');

        socket_write($this->client->socket, $message->message, strlen($message->message));

        $message->response = (string)socket_read($this->client->socket, 2048);
        $message->response_at = date('Y-m-d H:i:s');

        $message->save();
    }

    /**
     * @param mixed $socket
     *
     * @return bool
     */
    protected function isSocket(mixed $socket): bool
    {
        return $socket && ($socket instanceof Socket);
    }

    /**
     * @param \Throwable $e
     *
     * @return void
     */
    protected function error(Throwable $e): void
    {
        report($e);
    }
}
