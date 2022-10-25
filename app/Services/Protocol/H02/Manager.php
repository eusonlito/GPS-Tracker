<?php declare(strict_types=1);

namespace App\Services\Protocol\H02;

use App\Services\Protocol\ProtocolAbstract;
use App\Services\Protocol\Resource;

class Manager extends ProtocolAbstract
{
    /**
     * @return string
     */
    public function code(): string
    {
        return 'h02';
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return 'H02';
    }

    /**
     * @param string $body
     *
     * @return array
     */
    public function resources(string $body): array
    {
        preg_match_all('/\*[^#]+#/', $body, $matches);

        return array_filter(
            array_map(fn ($body) => $this->resource($body), $matches[0]),
            static fn ($resource) => $resource->isValid()
        );
    }

    /**
     * @param string $body
     *
     * @return \App\Services\Protocol\Resource
     */
    public function resource(string $body): Resource
    {
        return Resource::new((array)Parser::new($body)->data());
    }
}
