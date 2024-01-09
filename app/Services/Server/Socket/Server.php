<?php declare(strict_types=1);

namespace App\Services\Server\Socket;

use Closure;
use Exception;
use Socket;
use Throwable;
use App\Services\Server\Connection;
use App\Services\Server\ServerAbstract;
use App\Services\Server\Logger;

class Server extends ServerAbstract
{
    /**
     * @const int
     */
    protected const SOCKET_TIMEOUT = 600;

    /**
     * @var ?\Socket
     */
    protected ?Socket $socket;

    /**
     * @var int
     */
    protected int $socketType = 1;

    /**
     * @var int
     */
    protected int $socketProtocol = 0;

    /**
     * @param string $type
     *
     * @return self
     */
    public function socketType(string $type): self
    {
        $this->socketType = match ($type) {
            'stream' => SOCK_STREAM,
            default => throw new Exception(sprintf('Invalid Socket Type %s', $type)),
        };

        return $this;
    }

    /**
     * @param string $protocol
     *
     * @return self
     */
    public function socketProtocol(string $protocol): self
    {
        $this->socketProtocol = match ($protocol) {
            'ip' => 0,
            'tcp' => 6,
            'udp' => 17,
            default => throw new Exception(sprintf('Invalid Socket Protocol %s', $protocol)),
        };

        return $this;
    }

    /**
     * @param \Closure $handler
     *
     * @return void
     */
    public function accept(Closure $handler): void
    {
        $this->create();
        $this->option();
        $this->bind();
        $this->listen();
        $this->nonblock();

        set_time_limit(0);

        $this->gracefulShutdown();

        try {
            $this->read($handler);
        } catch (Throwable $e) {
            $this->error($e);
            $this->stop();
        }
    }

    /**
     * @return void
     */
    protected function create(): void
    {
        $this->socket = socket_create(AF_INET, $this->socketType, $this->socketProtocol);
    }

    /**
     * @return void
     */
    protected function option(): void
    {
        socket_set_option($this->socket, SOL_SOCKET, SO_REUSEADDR, 1);
    }

    /**
     * @return void
     */
    protected function bind(): void
    {
        socket_bind($this->socket, '0.0.0.0', $this->port);
    }

    /**
     * @return void
     */
    protected function listen(): void
    {
        socket_listen($this->socket);
    }

    /**
     * @return void
     */
    protected function nonblock(): void
    {
        socket_set_nonblock($this->socket);
    }

    /**
     * @param \Closure $handler
     *
     * @return void
     */
    protected function read(Closure $handler): void
    {
        do {
            usleep(10000);

            $sockets = $this->pool->sockets();

            if ($this->select($sockets) === 0) {
                continue;
            }

            if (in_array($this->socket, $sockets)) {
                $this->connectionAdd($sockets);
            }

            if (empty($sockets)) {
                continue;
            }

            foreach ($sockets as $socket) {
                if ($connection = $this->pool->bySocket($socket)) {
                    $this->connectionRead($connection, $handler);
                }
            }
        } while (true);
    }

    /**
     * @param array &$sockets
     *
     * @return int
     */
    protected function select(array &$sockets): int
    {
        $write = $except = null;

        array_push($sockets, $this->socket);

        return intval(socket_select($sockets, $write, $except, null));
    }

    /**
     * @param array &$sockets
     *
     * @return void
     */
    protected function connectionAdd(array &$sockets): void
    {
        $this->connectionAccept();

        unset($sockets[array_search($this->socket, $sockets)]);
    }

    /**
     * @return void
     */
    protected function connectionAccept(): void
    {
        if (empty($socket = socket_accept($this->socket))) {
            return;
        }

        $timeout = ['sec' => 5, 'usec' => 0];

        socket_set_option($socket, SOL_SOCKET, SO_RCVTIMEO, $timeout);
        socket_set_option($socket, SOL_SOCKET, SO_SNDTIMEO, $timeout);

        $this->pool->add($connection = new Connection($this->port, $socket));

        if ($connection->isDebuggable() === false) {
            return;
        }

        $this->log('[CONNECTIONS]', $this->pool->count());
        $this->log('['.$connection->getId().'] [CONNECTED]', $connection->__toArray());
    }

    /**
     * @param \App\Services\Server\Connection $connection
     * @param \Closure $handler
     *
     * @return void
     */
    protected function connectionRead(Connection $connection, Closure $handler): void
    {
        try {
            $this->connectionReadHandle($connection, $handler);
        } catch (Throwable $e) {
            $this->connectionReadError($connection, $e);
        }
    }

    /**
     * @param \App\Services\Server\Connection $connection
     * @param \Closure $handler
     *
     * @return void
     */
    protected function connectionReadHandle(Connection $connection, Closure $handler): void
    {
        if (Client::new($connection, $handler)->debug($this->debug)->handle() === false) {
            $connection->close();
        }
    }

    /**
     * @param \App\Services\Server\Connection $connection
     * @param \Throwable $e
     *
     * @return void
     */
    protected function connectionReadError(Connection $connection, Throwable $e): void
    {
        $connection->close();

        $this->error($e);
    }

    /**
     * @param ?\Socket &$socket
     *
     * @return void
     */
    protected function close(?Socket &$socket): void
    {
        if ($socket) {
            try {
                socket_close($socket);
            } catch (Throwable $e) {
                $this->error($e);
            }
        }

        $socket = null;
    }

    /**
     * @return void
     */
    protected function gracefulShutdown(): void
    {
        if (function_exists('pcntl_signal') === false) {
            return;
        }

        pcntl_signal(SIGINT, [$this, 'gracefulShutdownHandler']);
        pcntl_signal(SIGTERM, [$this, 'gracefulShutdownHandler']);
    }

    /**
     * @return void
     */
    public function gracefulShutdownHandler(): void
    {
        $this->stop();
        exit;
    }

    /**
     * @return void
     */
    public function stop(): void
    {
        $this->pool->stop();

        if ($this->socket) {
            $this->close($this->socket);
        }

        $this->socket = null;
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
        if ($this->debug) {
            Logger::port($this->port)->info($message, $data);
        }
    }
}
