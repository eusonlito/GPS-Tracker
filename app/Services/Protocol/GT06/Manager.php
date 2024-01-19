<?php declare(strict_types=1);

namespace App\Services\Protocol\GT06;

use App\Services\Protocol\GT06\Parser\Auth as AuthParser;
use App\Services\Protocol\GT06\Parser\Heartbeat as HeartbeatParser;
use App\Services\Protocol\GT06\Parser\Location as LocationParser;
use App\Services\Protocol\ProtocolAbstract;
use App\Services\Server\Socket\Server;

class Manager extends ProtocolAbstract
{
    /**
     * @return string
     */
    public function code(): string
    {
        return 'gt06';
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return 'GT06';
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
            ->socketProtocol('ip');
    }

    /**
     * @return array
     */
    protected function parsers(): array
    {
        return [
            AuthParser::class,
            HeartbeatParser::class,
            LocationParser::class,
        ];
    }

    /**
     * @param string $body
     *
     * @return array
     */
    protected function bodies(string $body): array
    {
        return array_filter(array_map('trim', explode('0d0a', $body)));
    }
}
