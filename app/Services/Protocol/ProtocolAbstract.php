<?php declare(strict_types=1);

namespace App\Services\Protocol;

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
     * @param string $body
     *
     * @return \App\Services\Protocol\Resource
     */
    abstract public function resource(string $body): Resource;
}
