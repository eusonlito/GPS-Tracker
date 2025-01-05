<?php declare(strict_types=1);

namespace App\Services\Protocol\GT06;

use App\Services\Protocol\GT06\Parser\Auth as AuthParser;
use App\Services\Protocol\GT06\Parser\Heartbeat as HeartbeatParser;
use App\Services\Protocol\GT06\Parser\LocationGpsModular as LocationGpsModularParser;
use App\Services\Protocol\GT06\Parser\LocationLbs as LocationLbsParser;
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
            LocationGpsModularParser::class,
            LocationLbsParser::class,
        ];
    }

    /**
     * @param string $message
     *
     * @return array
     */
    public function messages(string $message): array
    {
        return array_filter(array_map('trim', explode('0d0a', $message)));
    }
}
