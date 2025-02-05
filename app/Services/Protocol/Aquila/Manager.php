<?php declare(strict_types=1);

namespace App\Services\Protocol\Aquila;

use App\Services\Protocol\Aquila\Parser\Location as LocationParser;
use App\Services\Protocol\ProtocolAbstract;
use App\Services\Server\Socket\Server;

class Manager extends ProtocolAbstract
{
    /**
     * @return string
     */
    public function code(): string
    {
        return 'aquila';
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return 'Aquila';
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
     * @param string $message
     *
     * @return array
     */
    public function messages(string $message): array
    {
        return array_filter(array_map('trim', explode("\n", hex2bin($message))));
    }

    /**
     * @return array
     */
    protected function parsers(): array
    {
        return [
            LocationParser::class,
        ];
    }
}
