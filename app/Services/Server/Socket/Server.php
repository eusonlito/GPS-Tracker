<?php declare(strict_types=1);

namespace App\Services\Server\Socket;

use Closure;
use Exception;
use Socket;
use stdClass;
use Throwable;
use App\Services\Server\ServerAbstract;

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
     * @var array
     */
    protected array $clients = [];

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
        $this->reuse();
        $this->bind();
        $this->listen();

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
     * @param \Closure $handler
     *
     * @return void
     */
    protected function read(Closure $handler): void
    {
        do {
            usleep(1000);

            $this->clientFilter();

            $sockets = $this->clientSockets();

            if ($this->select($sockets) === 0) {
                continue;
            }

            if (in_array($this->socket, $sockets)) {
                $sockets = $this->clientAdd($sockets);
            }

            foreach ($sockets as $socket) {
                $this->clientRead($socket, $handler);
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
     * @param array $sockets
     *
     * @return array
     */
    protected function clientAdd(array $sockets): array
    {
        $this->clientAccept();

        unset($sockets[array_search($this->socket, $sockets)]);

        return array_values($sockets);
    }

    /**
     * @return void
     */
    protected function clientAccept(): void
    {
        $this->clients[] = (object)[
            'socket' => socket_accept($this->socket),
            'timestamp' => time(),
            'data' => null,
        ];
    }

    /**
     * @param \Socket $socket
     * @param \Closure $handler
     *
     * @return void
     */
    protected function clientRead(Socket $socket, Closure $handler): void
    {
        $client = $this->clientBySocket($socket);

        if ($client === null) {
            return;
        }

        $response = Client::new($client, $handler)->handle();

        if ($response === false) {
            $this->close($client->socket);
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
    protected function reuse(): void
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
     * @param \Socket $socket
     *
     * @return ?\stdClass
     */
    protected function clientBySocket(Socket $socket): ?stdClass
    {
        foreach ($this->clients as $client) {
            if ($client->socket === $socket) {
                return $client;
            }
        }

        return null;
    }

    /**
     * @return array
     */
    protected function clientSockets(): array
    {
        return array_filter(array_column($this->clients, 'socket'));
    }

    /**
     * @return void
     */
    protected function clientFilter(): void
    {
        foreach ($this->clients as &$client) {
            if (empty($client->socket)) {
                $client = null;

                continue;
            }

            if ((time() - $client->timestamp) < static::SOCKET_TIMEOUT) {
                continue;
            }

            $this->close($client->socket);

            $client = null;
        }

        $this->clients = array_filter($this->clients);
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
        foreach ($this->clientSockets() as $client) {
            $this->close($client);
        }

        if ($this->socket) {
            $this->close($this->socket);
        }

        $this->clients = [];
        $this->socket = null;
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
        return (str_contains($e->getMessage(), ' closed ') === false)
            && (str_contains($e->getMessage(), ' unable to write to socket') === false)
            && (str_contains($e->getMessage(), ' reset by peer') === false);
    }
}
