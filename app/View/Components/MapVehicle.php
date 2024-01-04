<?php declare(strict_types=1);

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;
use App\Domains\Position\Model\Position as PositionModel;
use App\Domains\Vehicle\Model\Collection\Vehicle as VehicleCollection;
use App\Domains\Vehicle\Model\Vehicle as VehicleModel;

class MapVehicle extends Component
{
    /**
     * @param \App\Domains\Vehicle\Model\Collection\Vehicle $vehicles
     * @param bool $sidebarHidden = false
     *
     * @return self
     */
    public function __construct(
        readonly public VehicleCollection $vehicles,
        readonly public bool $sidebarHidden = false,
    ) {
    }

    /**
     * @return \Illuminate\View\View
     */
    public function render(): View
    {
        return view('components.map-vehicle', [
            'id' => uniqid(),
            'vehiclesJson' => $this->vehiclesJson(),
            'filterFinished' => $this->filterFinished(),
            'filterFinishedMinutes' => $this->filterFinishedMinutes(),
        ]);
    }

    /**
     * @return string
     */
    protected function vehiclesJson(): string
    {
        return $this->vehicles
            ->toBase()
            ->map($this->vehiclesJsonMap(...))
            ->sortBy('name')
            ->values()
            ->toJson();
    }

    /**
     * @param \App\Domains\Vehicle\Model\Vehicle $vehicle
     *
     * @return array
     */
    protected function vehiclesJsonMap(VehicleModel $vehicle): array
    {
        return [
            'id' => $vehicle->id,
            'name' => $vehicle->name,
            'plate' => $vehicle->plate,
            'position' => $this->vehiclesJsonMapPosition($vehicle->positionLast),
            'vehicle' => $this->vehiclesJsonMapVehicle($vehicle->vehicle),
        ];
    }

    /**
     * @param ?\App\Domains\Vehicle\Model\Vehicle $vehicle
     *
     * @return ?array
     */
    protected function vehiclesJsonMapVehicle(?VehicleModel $vehicle): ?array
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
    protected function vehiclesJsonMapPosition(?PositionModel $position): ?array
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
            '' => __('map-vehicle.filter.finished-all'),
            '0' => __('map-vehicle.filter.finished-no'),
            '1' => __('map-vehicle.filter.finished-yes'),
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
