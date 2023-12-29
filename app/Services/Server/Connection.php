<?php declare(strict_types=1);

namespace App\Services\Server;

use Socket;
use Throwable;

class Connection
{
    /**
     * @const int
     */
    protected const TIMEOUT = 600;

    /**
     * @var int
     */
    protected int $timestamp;

    /**
     * @var array
     */
    protected array $data = [];

    /**
     * @param ?\Socket $socket
     *
     * @return self
     */
    public function __construct(protected ?Socket $socket)
    {
        $this->refresh();
    }

    /**
     * @return int
     */
    public function getTimestamp(): int
    {
        return $this->timestamp;
    }

    /**
     * @return self
     */
    public function refresh(): self
    {
        $this->timestamp = time();

        return $this;
    }

    /**
     * @param array $data
     *
     * @return self
     */
    public function setData(array $data): self
    {
        $this->data = array_merge($this->data, $data);

        return $this;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @return ?\Socket
     */
    public function getSocket(): ?Socket
    {
        return $this->socket;
    }

    /**
     * @return void
     */
    public function close(): void
    {
        if ($this->socket) {
            try {
                socket_close($this->socket);
            } catch (Throwable $e) {
                $this->error($e);
            }
        }

        $this->socket = null;
    }

    /**
     * @return bool
     */
    public function isValid(): bool
    {
        return $this->socket
            && ($this->socket instanceof Socket)
            && ((time() - $this->timestamp) < static::TIMEOUT);
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
}
