<?php declare(strict_types=1);

namespace App\Services\Protocol\Queclink;

use App\Services\Protocol\Queclink\Parser\Location as LocationParser;
use App\Services\Protocol\ProtocolAbstract;
use App\Services\Server\Socket\Server;

class Manager extends ProtocolAbstract
{
    /**
     * @return string
     */
    public function code(): string
    {
        return 'queclink';
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return 'Queclink';
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
        if ($this->messageIsValidHex($message) === false) {
            return [];
        }

        preg_match_all('/\+[^\$]+\$/', hex2bin($message), $matches);

        return $matches[0];
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
