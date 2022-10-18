<?php declare(strict_types=1);

namespace App\Services\Socket;

use Closure;
use Socket;
use Throwable;
use Illuminate\Support\Facades\Log;

class Server
{
    /**
     * @var ?\Socket
     */
    protected ?Socket $socket;

    /**
     * @var array
     */
    protected array $clients = [];

    /**
     * @return self
     */
    public static function new(): self
    {
        return new static(...func_get_args());
    }

    /**
     * @param int $port
     *
     * @return self
     */
    public function __construct(protected int $port)
    {
    }

    /**
     * @return void
     */
    public function kill(): void
    {
        if ($this->isBusy() === false) {
            return;
        }

        shell_exec('fuser -k -SIGINT '.$this->port.'/tcp > /dev/null 2>&1');

        $count = 0;

        while (($count < 5) && $this->isBusy()) {
            sleep(++$count);
        }
    }

    /**
     * @return bool
     */
    public function isBusy(): bool
    {
        try {
            $fp = fsockopen('0.0.0.0', $this->port);
        } catch (Throwable $e) {
            return false;
        }

        fclose($fp);

        return true;
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

            $read = array_filter(array_merge([$this->socket], $this->clientSockets()));
            $write = null;
            $except = null;

            if (socket_select($read, $write, $except, null) === 0) {
                continue;
            }

            if (in_array($this->socket, $read)) {
                $this->client();
            }

            foreach ($this->clients as &$client) {
                $socket = $client->socket;

                if ($this->isSocket($socket) === false) {
                    continue;
                }

                if (in_array($socket, $read) === false) {
                    continue;
                }

                $buffer = socket_read($socket, 2048);

                if ($buffer === null) {
                    $this->close($socket);

                    continue;
                }

                if (empty($buffer = trim($buffer))) {
                    continue;
                }

                $client->timestamp = time();

                $response = 'OK';

                try {
                    $response = $handler($buffer) ?? $response;
                } catch (Throwable $e) {
                    $this->error($e);
                }

                socket_write($socket, $response, strlen($response));
            }
        } while (true);
    }

    /**
     * @return void
     */
    protected function create(): void
    {
        $this->socket = socket_create(AF_INET, SOCK_STREAM, 0);
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
     * @return void
     */
    protected function client(): void
    {
        $this->clients[] = (object)[
            'socket' => socket_accept($this->socket),
            'timestamp' => time(),
        ];
    }

    /**
     * @return array
     */
    protected function clientSockets(): array
    {
        return array_column($this->clients, 'socket');
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

            if ((time() - $client->timestamp) < 600) {
                continue;
            }

            $this->close($client->socket);

            $client = null;
        }

        $this->clients = array_filter($this->clients);
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
            }
        }

        $socket = null;
    }

    /**
     * @return void
     */
    protected function gracefulShutdown(): void
    {
        pcntl_signal(SIGINT, fn () => $this->stop());
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
    }

    /**
     * @param \Throwable $e
     *
     * @return void
     */
    protected function error(Throwable $e): void
    {
        Log::error($e);
    }
}
