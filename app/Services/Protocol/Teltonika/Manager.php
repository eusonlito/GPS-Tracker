<?php declare(strict_types=1);

namespace App\Services\Protocol\Teltonika;

use App\Services\Protocol\Teltonika\Parser\Auth as AuthParser;
use App\Services\Protocol\Teltonika\Parser\Locations as LocationsParser;
use App\Services\Protocol\ProtocolAbstract;
use App\Services\Server\Socket\Server;

class Manager extends ProtocolAbstract
{
    /**
     * @return string
     */
    public function code(): string
    {
        return 'teltonika';
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return 'Teltonika';
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
     * @param string $body
     *
     * @return array
     */
    protected function bodies(string $body): array
    {
        return [$body];
    }

    /**
     * @return array
     */
    protected function parsers(): array
    {
        return [
            AuthParser::class,
            LocationsParser::class,
        ];
    }
}
