<?php declare(strict_types=1);

namespace App\Domains\Dashboard\Service\Controller;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Domains\Device\Model\Device as DeviceModel;
use App\Domains\Trip\Model\Trip as TripModel;

class Index extends ControllerAbstract
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
            'devices' => $this->devices(),
            'device' => $this->device(),
            'trips' => $this->trips(),
            'trip' => $this->trip(),
            'positions' => $this->positions(),
        ];
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    protected function devices(): Collection
    {
        return $this->cache[__FUNCTION__] ??= DeviceModel::byUserId($this->auth->id)->list()->get();
    }

    /**
     * @return ?\App\Domains\Device\Model\Device
     */
    protected function device(): ?DeviceModel
    {
        return $this->cache[__FUNCTION__] ??= $this->devices()->firstWhere('id', $this->request->input('device_id'))
            ?: $this->devices()->first();
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    protected function trips(): Collection
    {
        if ($this->device() === null) {
            return collect();
        }

        return $this->cache[__FUNCTION__] ??= $this->device()->trips()->list()->limit(50)->get();
    }

    /**
     * @return ?\App\Domains\Trip\Model\Trip
     */
    protected function trip(): ?TripModel
    {
        return $this->cache[__FUNCTION__] ??= $this->trips()->firstWhere('id', $this->request->input('trip_id'))
            ?: $this->trips()->first();
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    protected function positions(): Collection
    {
        if ($this->trip() === null) {
            return collect();
        }

        return $this->cache[__FUNCTION__] ??= $this->trip()
            ->positions()
            ->selectPointAsLatitudeLongitude()
            ->withCity()
            ->list()
            ->get();
    }
}
