<?php declare(strict_types=1);

namespace App\Domains\Refuel\Service\Controller;

use App\Domains\Refuel\Model\Collection\Refuel as Collection;
use App\Domains\Refuel\Model\Refuel as Model;

class Map extends IndexMapAbstract
{
    /**
     * @return array
     */
    public function data(): array
    {
        return $this->dataCore() + [
            'vehicles' => $this->vehicles(),
            'vehicles_multiple' => $this->vehiclesMultiple(),
            'vehicle' => $this->vehicle(),
            'vehicle_empty' => $this->vehicleEmpty(),
            'countries' => $this->countries(),
            'country' => $this->country(),
            'states' => $this->states(),
            'state' => $this->state(),
            'cities' => $this->cities(),
            'city' => $this->city(),
            'date_min' => $this->dateMin(),
            'list' => $this->list(),
        ];
    }

    /**
     * @return \App\Domains\Refuel\Model\Collection\Refuel
     */
    protected function list(): Collection
    {
        return $this->cache(
            fn () => Model::query()
                ->whenUserId($this->user()?->id)
                ->whenVehicleId($this->vehicle()?->id)
                ->whenDateAtBetween($this->request->input('start_at'), $this->request->input('end_at'))
                ->whenCityStateCountryId($this->city()?->id, $this->state()?->id, $this->country()?->id)
                ->withSimple('vehicle')
                ->withCityState()
                ->list()
                ->get()
        );
    }
}
