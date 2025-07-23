<?php declare(strict_types=1);

namespace App\Services\Protocol\TK102;

use App\Services\Protocol\TK102\Parser\Command as CommandParser;
use App\Services\Protocol\TK102\Parser\Location as LocationParser;
use App\Services\Protocol\ProtocolAbstract;
use App\Services\Server\Socket\Server;

class Manager extends ProtocolAbstract
{
    /**
     * @return string
     */
    public function code(): string
    {
        return 'tk102';
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return 'TK102';
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
            CommandParser::class,
            LocationParser::class,
        ];
    }

    /**
     * @param string $message
     *
     * @return array
     */
    public function messages(string $message): array
    {
        if ($this->messageIsValidHex($message) === false) {
            return [];
        }

        return array_filter(array_map('trim', preg_split('/[\n\r]/', hex2bin($message))));
    }
}
