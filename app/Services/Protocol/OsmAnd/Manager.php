<?php declare(strict_types=1);

namespace App\Services\Protocol\OsmAnd;

use App\Services\Protocol\OsmAnd\Parser\Location as LocationParser;
use App\Services\Protocol\ProtocolAbstract;
use App\Services\Server\Http\Server;

class Manager extends ProtocolAbstract
{
    /**
     * @return string
     */
    public function code(): string
    {
        return 'osmand';
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return 'OsmAnd';
    }

    /**
     * @param int $port
     *
     * @return \App\Services\Server\Http\Server
     */
    public function server(int $port): Server
    {
        return Server::new($port);
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
