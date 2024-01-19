<?php declare(strict_types=1);

namespace App\Services\Protocol\DebugSocket;

use App\Services\Protocol\ProtocolAbstract;
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
            ->socketType('stream')
            ->socketProtocol('tcp');
    }

    /**
     * @return array
     */
    protected function parsers(): array
    {
        return [];
    }

    /**
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter
     *
     * @param string $body
     * @param array $data = []
     *
     * @return array
     */
    public function resources(string $body, array $data = []): array
    {
        return [];
    }

    /**
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter
     *
     * @param string $body
     *
     * @return array
     */
    protected function bodies(string $body): array
    {
        return [];
    }
}
