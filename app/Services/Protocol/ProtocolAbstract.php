<?php declare(strict_types=1);

namespace App\Services\Protocol;

use App\Services\Protocol\Resource\ResourceAbstract;
use App\Services\Server\ServerAbstract;

abstract class ProtocolAbstract
{
    /**
     * @return string
     */
    abstract public function code(): string;

    /**
     * @return string
     */
    abstract public function name(): string;

    /**
     * @param int $port
     *
     * @return \App\Services\Server\ServerAbstract
     */
    abstract public function server(int $port): ServerAbstract;

    /**
     * @param string $body
     *
     * @return array
     */
    abstract public function resources(string $body): array;

    /**
     * @param string $body
     *
     * @return ?\App\Services\Protocol\Resource\ResourceAbstract
     */
    abstract public function resource(string $body): ?ResourceAbstract;
}
