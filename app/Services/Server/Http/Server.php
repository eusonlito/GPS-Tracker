<?php declare(strict_types=1);

namespace App\Services\Server\Http;

use Closure;
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
     * @var ?resource
     */
    protected $socket;

    /**
     * @var array
     */
    protected array $clients = [];

    /**
     * @param \Closure $handler
     *
     * @return void
     */
    public function accept(Closure $handler): void
    {
        $this->create();

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

        return intval(stream_select($sockets, $write, $except, null));
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
            'socket' => stream_socket_accept($this->socket, 1),
            'timestamp' => time(),
            'data' => [],
        ];
    }

    /**
     * @param resource $socket
     * @param \Closure $handler
     *
     * @return void
     */
    protected function clientRead($socket, Closure $handler): void
    {
        $client = $this->clientBySocket($socket);

        if ($client === null) {
            return;
        }

        Client::new($client, $handler)->handle();
    }

    /**
     * @return void
     */
    protected function create(): void
    {
        $this->socket = stream_socket_server('tcp://0.0.0.0:'.$this->port);
    }

    /**
     * @param resource $socket
     *
     * @return ?\stdClass
     */
    protected function clientBySocket($socket): ?stdClass
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
     * @param ?resource &$socket
     *
     * @return void
     */
    protected function close(&$socket): void
    {
        if ($socket) {
            try {
                fclose($socket);
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
        return str_contains($e->getMessage(), ' closed ') === false;
    }
}
