<?php declare(strict_types=1);

namespace App\Domains\Device\Service\Controller;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use App\Domains\Device\Model\Collection\Device as Collection;
use App\Domains\Device\Model\Device as Model;

class Map extends ControllerAbstract
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Contracts\Auth\Authenticatable $auth
     *
     * @return self
     */
    public function __construct(protected Request $request, protected Authenticatable $auth)
    {
    }

    /**
     * @return array
     */
    public function data(): array
    {
        return [
            'list' => $this->list(),
        ];
    }

    /**
     * @return \App\Domains\Device\Model\Collection\Device
     */
    protected function list(): Collection
    {
        return $this->cache[__FUNCTION__] ??= Model::query()
            ->byUserId($this->auth->id)
            ->withVehicle()
            ->withPositionLast()
            ->list()
            ->get()
            ->filter(static fn ($device) => $device->positionLast);
    }
}
