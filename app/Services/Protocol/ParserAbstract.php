<?php declare(strict_types=1);

namespace App\Services\Protocol;

use App\Services\Protocol\Resource\ResourceAbstract;
use App\Services\Protocol\Resource\Auth as ResourceAuth;
use App\Services\Protocol\Resource\Command as ResourceCommand;
use App\Services\Protocol\Resource\Heartbeat as ResourceHeartbeat;
use App\Services\Protocol\Resource\Location as ResourceLocation;
use App\Services\Protocol\Resource\Sms as ResourceSms;

abstract class ParserAbstract
{
    /**
     * @var array
     */
    protected array $values = [];

    /**
     * @var array<\App\Services\Protocol\Resource\ResourceAbstract>
     */
    protected array $resources = [];

    /**
     * @var array
     */
    protected array $cache = [];

    /**
     * @return self
     */
    public static function new(): self
    {
        return new static(...func_get_args());
    }

    /**
     * @param string $message
     * @param array $data = []
     *
     * @return self
     */
    public function __construct(protected string $message, protected array $data = [])
    {
    }

    /**
     * @return array<\App\Services\Protocol\Resource\ResourceAbstract>
     */
    public function resources(): array
    {
        return $this->resources;
    }

    /**
     * @return void
     */
    protected function add(ResourceAbstract $resource): void
    {
        $this->resources[] = $resource;
    }

    /**
     * @return void
     */
    protected function addIfValid(?ResourceAbstract $resource): void
    {
        if ($resource?->isValid()) {
            $this->add($resource);
        }
    }

    /**
     * @return \App\Services\Protocol\Resource\Auth
     */
    protected function resourceAuth(): ResourceAuth
    {
        return new ResourceAuth([
            'message' => $this->message(),
            'serial' => $this->serial(),
            'response' => $this->response(),
            'data' => $this->data(),
        ]);
    }

    /**
     * @return \App\Services\Protocol\Resource\Command
     */
    protected function resourceCommand(): ResourceCommand
    {
        return new ResourceCommand([
            'message' => $this->message(),
            'serial' => $this->serial(),
            'type' => $this->type(),
            'payload' => $this->payload(),
            'data' => $this->data(),
            'response' => $this->response(),
        ]);
    }

    /**
     * @return \App\Services\Protocol\Resource\Heartbeat
     */
    protected function resourceHeartbeat(): ResourceHeartbeat
    {
        return new ResourceHeartbeat([
            'message' => $this->message(),
            'serial' => $this->serial(),
            'data' => $this->data(),
            'response' => $this->response(),
        ]);
    }

    /**
     * @return \App\Services\Protocol\Resource\Location
     */
    protected function resourceLocation(): ResourceLocation
    {
        return new ResourceLocation([
            'message' => $this->message(),
            'serial' => $this->serial(),
            'latitude' => $this->latitude(),
            'longitude' => $this->longitude(),
            'speed' => $this->speed(),
            'signal' => $this->signal(),
            'direction' => $this->direction(),
            'datetime' => $this->datetime(),
            'timezone' => $this->timezone(),
            'data' => $this->data(),
            'response' => $this->response(),
        ]);
    }

    /**
     * @return \App\Services\Protocol\Resource\Sms
     */
    protected function resourceSms(): ResourceSms
    {
        return new ResourceSms([
            'message' => $this->message(),
            'serial' => $this->serial(),
            'type' => $this->type(),
            'payload' => $this->payload(),
            'response' => $this->response(),
        ]);
    }

    /**
     * @return string
     */
    protected function message(): string
    {
        return $this->message;
    }

    /**
     * @return array
     */
    protected function data(): array
    {
        return $this->data;
    }
}
