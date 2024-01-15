<?php declare(strict_types=1);

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;
use App\Domains\Device\Model\Collection\Device as DeviceCollection;
use App\Domains\Device\Model\Device as DeviceModel;
use App\Domains\Position\Model\Position as PositionModel;
use App\Domains\Vehicle\Model\Vehicle as VehicleModel;

class MapDevice extends Component
{
    /**
     * @param \App\Domains\Device\Model\Collection\Device $devices
     * @param bool $sidebarHidden = false
     *
     * @return self
     */
    public function __construct(
        readonly public DeviceCollection $devices,
        readonly public bool $sidebarHidden = false,
    ) {
    }

    /**
     * @return \Illuminate\View\View
     */
    public function render(): View
    {
        return view('components.map-device', [
            'id' => uniqid(),
            'devicesJson' => $this->devicesJson(),
            'filterFinished' => $this->filterFinished(),
            'filterFinishedMinutes' => $this->filterFinishedMinutes(),
        ]);
    }

    /**
     * @return string
     */
    protected function devicesJson(): string
    {
        return $this->devices
            ->toBase()
            ->map($this->devicesJsonMap(...))
            ->sortBy('name')
            ->values()
            ->toJson();
    }

    /**
     * @param \App\Domains\Device\Model\Device $device
     *
     * @return array
     */
    protected function devicesJsonMap(DeviceModel $device): array
    {
        return [
            'id' => $device->id,
            'name' => $device->name,
            'position' => $this->devicesJsonMapPosition($device->positionLast),
            'vehicle' => $this->devicesJsonMapVehicle($device->vehicle),
        ];
    }

    /**
     * @param ?\App\Domains\Vehicle\Model\Vehicle $vehicle
     *
     * @return ?array
     */
    protected function devicesJsonMapVehicle(?VehicleModel $vehicle): ?array
    {
        if ($vehicle === null) {
            return null;
        }

        return [
            'id' => $vehicle->id,
            'name' => $vehicle->name,
            'plate' => $vehicle->plate,
        ];
    }

    /**
     * @param ?\App\Domains\Position\Model\Position $position
     *
     * @return ?array
     */
    protected function devicesJsonMapPosition(?PositionModel $position): ?array
    {
        if ($position === null) {
            return null;
        }

        return [
            'id' => $position->id,
            'date_at' => $position->date_at,
            'date_utc_at' => $position->date_utc_at,
            'latitude' => $position->latitude,
            'longitude' => $position->longitude,
            'direction' => $position->direction,
            'speed' => helper()->unit('speed', $position->speed),
            'speed_human' => helper()->unitHuman('speed', $position->speed),
            'city' => $position->city?->name,
            'state' => $position->city?->state->name,
        ];
    }

    /**
     * @return array
     */
    protected function filterFinished(): array
    {
        return [
            '' => __('map-device.filter.finished-all'),
            '0' => __('map-device.filter.finished-no'),
            '1' => __('map-device.filter.finished-yes'),
        ];
    }

    /**
     * @return string
     */
    protected function filterFinishedMinutes(): string
    {
        return app('configuration')->string('trip_wait_minutes');
    }
}
