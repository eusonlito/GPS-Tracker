<?php declare(strict_types=1);

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;
use App\Domains\Refuel\Model\Collection\Refuel as RefuelCollection;
use App\Domains\Refuel\Model\Refuel as RefuelModel;
use App\Domains\Position\Model\Position as PositionModel;
use App\Domains\Vehicle\Model\Vehicle as VehicleModel;

class MapRefuel extends Component
{
    /**
     * @param \App\Domains\Refuel\Model\Collection\Refuel $refuels
     * @param bool $sidebarHidden = false
     *
     * @return self
     */
    public function __construct(
        readonly public RefuelCollection $refuels,
        readonly public bool $sidebarHidden = false,
    ) {
    }

    /**
     * @return \Illuminate\View\View
     */
    public function render(): View
    {
        return view('components.map-refuel', [
            'id' => uniqid(),
            'refuelsJson' => $this->refuelsJson(),
        ]);
    }

    /**
     * @return string
     */
    protected function refuelsJson(): string
    {
        return $this->refuels
            ->map($this->refuelsJsonMap(...))
            ->sortByDesc('date_at')
            ->values()
            ->toJson();
    }

    /**
     * @param \App\Domains\Refuel\Model\Refuel $refuel
     *
     * @return array
     */
    protected function refuelsJsonMap(RefuelModel $refuel): array
    {
        return [
            'id' => $refuel->id,
            'date_at' => $refuel->date_at,
            'price' => $refuel->price,
            'total' => $refuel->total,
            'position' => $this->refuelsJsonMapPosition($refuel->position),
            'vehicle' => $this->refuelsJsonMapVehicle($refuel->vehicle),
        ];
    }

    /**
     * @param ?\App\Domains\Vehicle\Model\Vehicle $vehicle
     *
     * @return ?array
     */
    protected function refuelsJsonMapVehicle(?VehicleModel $vehicle): ?array
    {
        if ($vehicle === null) {
            return null;
        }

        return [
            'id' => $vehicle->id,
            'name' => $vehicle->name,
        ];
    }

    /**
     * @param ?\App\Domains\Position\Model\Position $position
     *
     * @return ?array
     */
    protected function refuelsJsonMapPosition(?PositionModel $position): ?array
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
            'state' => $position->state?->name,
        ];
    }
}
