<?php declare(strict_types=1);

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;
use App\Domains\Refuel\Model\Collection\Refuel as RefuelCollection;
use App\Domains\Refuel\Model\Refuel as RefuelModel;
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
            ->toBase()
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
            'latitude' => $refuel->latitude,
            'longitude' => $refuel->longitude,
            'direction' => $refuel->direction,
            'city' => $refuel->city?->name,
            'state' => $refuel->city?->state->name,
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
}
