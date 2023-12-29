<?php declare(strict_types=1);

namespace App\Services\Protocol\Queclink;

use App\Services\Protocol\Queclink\Parser\Location as LocationParser;
use App\Services\Protocol\ProtocolAbstract;
use App\Services\Protocol\Resource\ResourceAbstract;
use App\Services\Server\Socket\Server;

class Manager extends ProtocolAbstract
{
    /**
     * @const array
     */
    protected const PARSERS = [
        LocationParser::class,
    ];

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
     * @param string $body
     * @param array $data = []
     *
     * @return array
     */
    public function resources(string $body, array $data = []): array
    {
        return array_filter(array_map(fn ($body) => $this->resource($body, $data), $this->bodies($body)));
    }

    /**
     * @param string $body
     *
     * @return array
     */
    protected function bodies(string $body): array
    {
        preg_match_all('/\+[^\$]+\$/', $body, $matches);

        return $matches[0];
    }

    /**
     * @param string $body
     * @param array $data = []
     *
     * @return ?\App\Services\Protocol\Resource\ResourceAbstract
     */
    public function resource(string $body, array $data = []): ?ResourceAbstract
    {
        foreach (static::PARSERS as $parser) {
            if (($resource = $parser::new($body, $data)->resource()) && $resource->isValid()) {
                return $resource;
            }
        }

        return null;
    }
}
