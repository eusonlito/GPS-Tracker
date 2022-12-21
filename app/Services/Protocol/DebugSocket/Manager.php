<?php declare(strict_types=1);

namespace App\Services\Protocol\DebugSocket;

use App\Services\Protocol\ProtocolAbstract;
use App\Services\Protocol\Resource\ResourceAbstract;
use App\Services\Server\Socket\Server;

class Manager extends ProtocolAbstract
{
    /**
     * @return string
     */
    public function code(): string
    {
        return 'debug-socket';
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return 'Debug Socket';
    }

    /**
     * @param int $port
     *
     * @return \App\Services\Server\Socket\Server
     */
    public function server(int $port): Server
    {
        return Server::new($port)
            ->socketType('raw')
            ->socketProtocol('tcp');
    }

    /**
     * @param string $body
     *
     * @return array
     */
    public function resources(string $body): array
    {
        return [];
    }

    /**
     * @param string $body
     *
     * @return ?\App\Services\Protocol\Resource\ResourceAbstract
     */
    public function resource(string $body): ?ResourceAbstract
    {
        return null;
    }
}
