<?php declare(strict_types=1);

namespace App\Services\Protocol\GPS103;

use App\Services\Protocol\GPS103\Parser\Auth as AuthParser;
use App\Services\Protocol\GPS103\Parser\Command as CommandParser;
use App\Services\Protocol\GPS103\Parser\Heartbeat as HeartbeatParser;
use App\Services\Protocol\GPS103\Parser\Location as LocationParser;
use App\Services\Protocol\ProtocolAbstract;
use App\Services\Server\Socket\Server;

class Manager extends ProtocolAbstract
{
    /**
     * @return string
     */
    public function code(): string
    {
        return 'gps103';
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return 'GPS103';
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
            CommandParser::class,
        ];
    }

    /**
     * @param string $body
     *
     * @return array
     */
    protected function bodies(string $body): array
    {
        return array_filter(array_map('trim', preg_split('/[\n;]/', $body)));
    }
}
