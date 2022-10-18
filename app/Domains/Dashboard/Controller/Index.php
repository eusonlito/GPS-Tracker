<?php declare(strict_types=1);

namespace App\Domains\Dashboard\Controller;

use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use App\Domains\Device\Model\Device as DeviceModel;
use App\Domains\Trip\Model\Trip as TripModel;

class Index extends ControllerAbstract
{
    /**
     * @var \Illuminate\Support\Collection
     */
    protected Collection $devices;

    /**
     * @var ?\App\Domains\Device\Model\Device
     */
    protected ?DeviceModel $device;

    /**
     * @var \Illuminate\Support\Collection
     */
    protected Collection $trips;

    /**
     * @var ?\App\Domains\Trip\Model\Trip
     */
    protected ?TripModel $trip;

    /**
     * @var \Illuminate\Support\Collection
     */
    protected Collection $positions;

    /**
     * @return \Illuminate\Http\Response
     */
    public function __invoke(): Response
    {
        $this->meta('title', __('dashboard-index.meta-title'));

        $this->devices();
        $this->device();
        $this->trips();
        $this->trip();
        $this->positions();

        return $this->page('dashboard.index', [
            'devices' => $this->devices,
            'device' => $this->device,
            'trips' => $this->trips,
            'trip' => $this->trip,
            'positions' => $this->positions,
        ]);
    }

    /**
     * @return void
     */
    protected function devices(): void
    {
        $this->devices = DeviceModel::byUserId($this->auth->id)->list()->get();
    }

    /**
     * @return void
     */
    protected function device(): void
    {
        $this->device = $this->devices->firstWhere('id', $this->request->input('device_id'))
            ?: $this->devices->first();
    }

    /**
     * @return void
     */
    protected function trips(): void
    {
        $this->trips = $this->device?->trips()->list()->limit(50)->get()
            ?? collect();
    }

    /**
     * @return void
     */
    protected function trip(): void
    {
        $this->trip = $this->trips->firstWhere('id', $this->request->input('trip_id'))
            ?: $this->trips->first();
    }

    /**
     * @return void
     */
    protected function positions(): void
    {
        $this->positions = $this->trip?->positions()->selectPointAsLatitudeLongitude()->list()->get()
            ?? collect();
    }
}
