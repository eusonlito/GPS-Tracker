<?php declare(strict_types=1);

namespace App\Domains\Shared\Service\Controller;

use Illuminate\Http\Request;
use App\Domains\Device\Model\Collection\Device as DeviceCollection;
use App\Domains\Device\Model\Device as DeviceModel;
use App\Domains\Position\Model\Collection\Position as PositionCollection;
use App\Domains\Trip\Model\Collection\Trip as TripCollection;
use App\Domains\Trip\Model\Trip as TripModel;

class Index extends ControllerAbstract
{
    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return self
     */
    public function __construct(Request $request)
    {
        $this->request = $request;

        $this->setUser();
    }

    /**
     * @return void
     */
    public function setUser(): void
    {
        if ($device = $this->device() ?: $this->devices()->first()) {
            $this->factory('User', $device->user)->action()->set();
        }
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
            'trip_next_code' => $this->tripNextCode(),
            'trip_previous_code' => $this->tripPreviousCode(),
            'positions' => $this->positions(),
        ];
    }

    /**
     * @return \App\Domains\Device\Model\Collection\Device
     */
    protected function devices(): DeviceCollection
    {
        return $this->cache(
            fn () => DeviceModel::query()
                ->whereSharedPublic()
                ->whenIds($this->requestArray('ids'))
                ->whenTripFinished($this->requestBool('finished', null))
                ->withVehicle()
                ->withWhereHasPositionLast()
                ->list()
                ->get()
        );
    }

    /**
     * @return ?\App\Domains\Device\Model\Device
     */
    protected function device(): ?DeviceModel
    {
        return $this->cache(
            fn () => $this->devices()
                ->firstWhere('code', $this->request->input('device_code'))
        );
    }

    /**
     * @return \App\Domains\Trip\Model\Collection\Trip
     */
    protected function trips(): TripCollection
    {
        if ($this->device() === null) {
            return new TripCollection();
        }

        return $this->cache(
            fn () => TripModel::query()
                ->selectSimple()
                ->byDeviceId($this->device()->id)
                ->whereSharedPublic()
                ->list()
                ->limit(100)
                ->get()
        );
    }

    /**
     * @return ?\App\Domains\Trip\Model\Trip
     */
    protected function trip(): ?TripModel
    {
        return $this->cache(
            fn () => $this->trips()
                ->firstWhere('code', $this->request->input('trip_code'))
                ?: $this->trips()->first()
        );
    }

    /**
     * @return ?string
     */
    protected function tripNextCode(): ?string
    {
        if ($this->trip() === null) {
            return null;
        }

        return $this->cache(
            fn () => $this->trips()
                ->reverse()
                ->firstWhere('start_utc_at', '>', $this->trip()->start_utc_at)
                ->code ?? null
        );
    }

    /**
     * @return ?string
     */
    protected function tripPreviousCode(): ?string
    {
        if ($this->trip() === null) {
            return null;
        }

        return $this->cache(
            fn () => $this->trips()
                ->firstWhere('start_utc_at', '<', $this->trip()->start_utc_at)
                ->code ?? null
        );
    }

    /**
     * @return \App\Domains\Position\Model\Collection\Position
     */
    protected function positions(): PositionCollection
    {
        if ($this->trip() === null) {
            return new PositionCollection();
        }

        return $this->cache(
            fn () => $this->trip()
                ->positions()
                ->withCityState()
                ->list()
                ->get()
        );
    }
}
