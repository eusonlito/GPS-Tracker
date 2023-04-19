<?php declare(strict_types=1);

namespace App\Domains\Trip\Service\Controller;

use App\Domains\City\Model\City as CityModel;
use App\Domains\City\Model\Collection\City as CityCollection;
use App\Domains\Country\Model\Collection\Country as CountryCollection;
use App\Domains\Country\Model\Country as CountryModel;
use App\Domains\Position\Model\Position as PositionModel;
use App\Domains\State\Model\Collection\State as StateCollection;
use App\Domains\State\Model\State as StateModel;
use App\Domains\Trip\Model\Collection\Trip as Collection;
use App\Domains\Trip\Model\Trip as Model;

class Search extends Index
{
    /**
     * @return void
     */
    protected function filtersDatesStartAt(): void
    {
        $start_at = $this->request->input('start_at');

        if ($start_at === '') {
            return;
        }

        if (is_null($start_at) || preg_match(static::DATE_REGEXP, $start_at) === 0) {
            $this->request->merge(['start_at' => '']);
        }
    }

    /**
     * @return array
     */
    public function data(): array
    {
        return [
            'vehicles' => $this->vehicles(),
            'vehicles_multiple' => $this->vehiclesMultiple(),
            'vehicle' => $this->vehicle(),
            'devices' => $this->devices(),
            'devices_multiple' => $this->devicesMultiple(),
            'device' => $this->device(),
            'countries' => $this->countries(),
            'country' => $this->country(),
            'states' => $this->states(),
            'state' => $this->state(),
            'cities' => $this->cities(),
            'city' => $this->city(),
            'date_min' => $this->dateMin(),
            'starts_ends' => $this->startsEnds(),
            'shared' => $this->shared(),
            'position' => $this->position(),
            'list' => $this->list(),
        ];
    }

    /**
     * @return \App\Domains\Country\Model\Collection\Country
     */
    protected function countries(): CountryCollection
    {
        return $this->cache[__FUNCTION__] ??= CountryModel::query()
            ->byVehicleIdWhenTripStartUtcAtDateBeforeAfter($this->vehicle()->id, $this->request->input('end_at'), $this->request->input('start_at'), $this->request->input('start_end'))
            ->list()
            ->get();
    }

    /**
     * @return ?\App\Domains\Country\Model\Country
     */
    protected function country(): ?CountryModel
    {
        return $this->cache[__FUNCTION__] ??= $this->countries()
            ->firstWhere('id', $this->request->input('country_id'));
    }

    /**
     * @return \App\Domains\State\Model\Collection\State
     */
    protected function states(): StateCollection
    {
        if (empty($country_id = intval($this->country()?->id))) {
            return new StateCollection();
        }

        return $this->cache[__FUNCTION__] ??= StateModel::query()
            ->byCountryId($country_id)
            ->byVehicleIdWhenTripStartUtcAtDateBeforeAfter($this->vehicle()->id, $this->request->input('end_at'), $this->request->input('start_at'), $this->request->input('start_end'))
            ->list()
            ->get();
    }

    /**
     * @return ?\App\Domains\State\Model\State
     */
    protected function state(): ?StateModel
    {
        return $this->cache[__FUNCTION__] ??= $this->states()
            ->firstWhere('id', $this->request->input('state_id'));
    }

    /**
     * @return \App\Domains\City\Model\Collection\City
     */
    protected function cities(): CityCollection
    {
        if (empty($state_id = intval($this->state()?->id))) {
            return new CityCollection();
        }

        return $this->cache[__FUNCTION__] ??= CityModel::query()
            ->byStateId($state_id)
            ->byVehicleIdWhenTripStartUtcAtDateBeforeAfter($this->vehicle()->id, $this->request->input('end_at'), $this->request->input('start_at'), $this->request->input('start_end'))
            ->list()
            ->get();
    }

    /**
     * @return ?\App\Domains\City\Model\City
     */
    protected function city(): ?CityModel
    {
        return $this->cache[__FUNCTION__] ??= $this->cities()
            ->firstWhere('id', $this->request->input('city_id'));
    }

    /**
     * @return ?\App\Domains\Position\Model\Position
     */
    protected function position(): ?PositionModel
    {
        return $this->cache[__FUNCTION__] ??= PositionModel::query()
            ->byUserId($this->auth->id)
            ->orderByDateUtcAtDesc()
            ->first();
    }

    /**
     * @return ?\App\Domains\Trip\Model\Collection\Trip
     */
    protected function list(): ?Collection
    {
        if ($this->listIsValid() === false) {
            return null;
        }

        return $this->cache[__FUNCTION__] ??= Model::query()
            ->selectSimple()
            ->byVehicleId($this->vehicle()->id)
            ->whenDeviceId($this->device()->id ?? null)
            ->whenStartUtcAtDateBeforeAfter($this->request->input('end_at'), $this->request->input('start_at'))
            ->whenCityStateCountry($this->city()?->id, $this->state()?->id, $this->country()?->id, $this->request->input('start_end'))
            ->whenShared($this->listWhenShared())
            ->whenFence($this->request->boolean('fence'), $this->request->float('fence_latitude'), $this->request->float('fence_longitude'), $this->request->float('fence_radius'))
            ->withDevice()
            ->withVehicle()
            ->list()
            ->get();
    }

    /**
     * @return bool
     */
    protected function listIsValid(): bool
    {
        return boolval(array_filter($this->request->except('vehicle_id', 'device_id')));
    }
}
