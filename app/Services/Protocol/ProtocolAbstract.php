<?php declare(strict_types=1);

namespace App\Services\Protocol;

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
    abstract protected function bodies(string $body): array;

    /**
     * @return array
     */
    abstract protected function parsers(): array;

    /**
     * @param string $body
     * @param array $data = []
     *
     * @return array
     */
    public function resources(string $body, array $data = []): array
    {
        $resources = [];

        foreach ($this->bodies($body) as $body) {
            foreach ($this->parsers() as $parser) {
                $valid = $parser::new($body, $data)->resources();

                if (empty($valid)) {
                    continue;
                }

                $resources = array_merge($resources, $valid);

                break;
            }
        }

        return $resources;
    }
}
