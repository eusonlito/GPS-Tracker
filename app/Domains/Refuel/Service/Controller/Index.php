<?php declare(strict_types=1);

namespace App\Domains\Refuel\Service\Controller;

use stdClass;
use App\Domains\Refuel\Model\Refuel as Model;
use App\Domains\Refuel\Model\Collection\Refuel as Collection;

class Index extends IndexMapAbstract
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
            'totals' => $this->totals(),
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
                ->whenVehicleId((int)$this->request->input('vehicle_id'))
                ->whenDateAtBetween($this->request->input('start_at'), $this->request->input('end_at'))
                ->whenCityStateCountryId($this->city()?->id, $this->state()?->id, $this->country()?->id)
                ->withSimple('user')
                ->withSimple('vehicle')
                ->list()
                ->get()
        );
    }

    /**
     * @return ?\stdClass
     */
    protected function totals(): ?stdClass
    {
        if ($this->list()->isEmpty()) {
            return null;
        }

        $totals = $this->list()->reduce($this->totalsRow(...), $this->totalsCarry());
        $totals->price = round($totals->total / $totals->quantity, 3);

        return $totals;
    }

    /**
     * @return \stdClass
     */
    protected function totalsCarry(): stdClass
    {
        return (object)[
            'distance' => 0,
            'quantity' => 0,
            'price' => 0,
            'total' => 0,
        ];
    }

    /**
     * @param \stdClass $carry
     * @param \App\Domains\Refuel\Model\Refuel $row
     *
     * @return \stdClass
     */
    protected function totalsRow(stdClass $carry, Model $row): stdClass
    {
        $carry->distance += $row->distance;
        $carry->quantity += $row->quantity;
        $carry->price += $row->price;
        $carry->total += $row->total;

        return $carry;
    }
}
