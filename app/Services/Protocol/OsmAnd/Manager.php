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
     * @param string $body
     *
     * @return array
     */
    protected function bodies(string $body): array
    {
        if ($body = trim(explode("\n", $body)[0] ?? '')) {
            return [$body];
        }

        return [];
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
