<?php declare(strict_types=1);

namespace App\Services\Server;

use Generator;
use Socket;

class Pool
{
    /**
     * @var array
     */
    protected array $list = [];

    /**
     * @param \App\Services\Server\Connection $connection
     *
     * @return self
     */
    public function add(Connection $connection): self
    {
        $this->list[] = $connection;

        return $this;
    }

    /**
     * @return array
     */
    public function get(): array
    {
        return $this->filter();
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return count($this->list);
    }

    /**
     * @return array
     */
    public function sockets(): array
    {
        return array_map(static fn ($connection) => $connection->getSocket(), $this->filter());
    }

    /**
     * @param \Socket $socket
     *
     * @return ?\App\Services\Server\Connection
     */
    public function bySocket(Socket $socket): ?Connection
    {
        foreach ($this->list as $connection) {
            if ($connection->getSocket() === $socket) {
                return $connection;
            }
        }

        return null;
    }

    /**
     * @param array $sockets
     *
     * @return \Generator
     */
    public function bySockets(array $sockets): Generator
    {
        foreach ($this->list as $connection) {
            if (in_array($connection->getSocket(), $sockets)) {
                yield $connection;
            }
        }

        yield from [];
    }

    /**
     * @return array
     */
    public function filter(): array
    {
        foreach ($this->list as $index => $connection) {
            if ($connection->isValid()) {
                continue;
            }

            $connection->close();

            unset($this->list[$index]);
        }

        return $this->list = array_values($this->list);
    }

    /**
     * @return void
     */
    public function stop(): void
    {
        foreach ($this->list as $connection) {
            $connection->close();
        }

        $this->list = [];
    }
}
