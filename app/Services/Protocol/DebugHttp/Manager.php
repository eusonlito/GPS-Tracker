<?php declare(strict_types=1);

namespace App\Services\Protocol\DebugHttp;

use App\Services\Protocol\ProtocolAbstract;
use App\Services\Protocol\Resource\ResourceAbstract;
use App\Services\Server\Http\Server;

class Manager extends ProtocolAbstract
{
    /**
     * @return string
     */
    public function code(): string
    {
        return 'debug-http';
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return 'Debug HTTP';
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
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter
     *
     * @param string $body
     *
     * @return array
     */
    public function resources(string $body): array
    {
        return [];
    }

    /**
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter
     *
     * @param string $body
     *
     * @return ?\App\Services\Protocol\Resource\ResourceAbstract
     */
    public function resource(string $body): ?ResourceAbstract
    {
        return null;
    }
}
