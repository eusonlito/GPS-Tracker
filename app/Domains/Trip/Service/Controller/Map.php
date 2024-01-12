<?php declare(strict_types=1);

namespace App\Domains\Trip\Service\Controller;

use App\Domains\City\Model\City as CityModel;
use App\Domains\City\Model\Collection\City as CityCollection;
use App\Domains\Country\Model\Collection\Country as CountryCollection;
use App\Domains\Country\Model\Country as CountryModel;
use App\Domains\State\Model\Collection\State as StateCollection;
use App\Domains\State\Model\State as StateModel;
use App\Domains\Trip\Model\Collection\Trip as Collection;
use App\Domains\Trip\Model\Trip as Model;

class Map extends Index
{
    /**
     * @const string
     */
    protected const START_AT_DEFAULT = '-1 days';

    /**
     * @return array
     */
    public function data(): array
    {
        return [
            'users' => $this->users(),
            'users_multiple' => $this->usersMultiple(),
            'user' => $this->user(),
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
            'filter_finished' => $this->filterFinished(),
            'show' => $this->show(),
        ];
    }

    /**
     * @return \App\Domains\Trip\Model\Collection\Trip
     */
    public function json(): Collection
    {
        return $this->list();
    }

    /**
     * @return \App\Domains\Country\Model\Collection\Country
     */
    protected function countries(): CountryCollection
    {
        return $this->cache(function () {
            return CountryModel::query()
                ->whenTripUserIdVehicleIdStartUtcAtBetween($this->user()?->id, $this->vehicle()?->id, $this->request->input('start_at'), $this->request->input('end_at'))
                ->list()
                ->get();
        });
    }

    /**
     * @return ?\App\Domains\Country\Model\Country
     */
    protected function country(): ?CountryModel
    {
        return $this->cache(
            fn () => $this->countries()->firstWhere('id', $this->request->input('country_id'))
        );
    }

    /**
     * @return \App\Domains\State\Model\Collection\State
     */
    protected function states(): StateCollection
    {
        return $this->cache(function () {
            if (empty($country_id = intval($this->country()?->id))) {
                return new StateCollection();
            }

            return StateModel::query()
                ->byCountryId($country_id)
                ->whenTripUserIdVehicleIdStartUtcAtBetween($this->user()?->id, $this->vehicle()?->id, $this->request->input('start_at'), $this->request->input('end_at'))
                ->list()
                ->get();
        });
    }

    /**
     * @return ?\App\Domains\State\Model\State
     */
    protected function state(): ?StateModel
    {
        return $this->cache(
            fn () => $this->states()->firstWhere('id', $this->request->input('state_id'))
        );
    }

    /**
     * @return \App\Domains\City\Model\Collection\City
     */
    protected function cities(): CityCollection
    {
        return $this->cache(function () {
            if (empty($state_id = intval($this->state()?->id))) {
                return new CityCollection();
            }

            return CityModel::query()
                ->byStateId($state_id)
                ->whenTripUserIdVehicleIdStartUtcAtBetween($this->user()?->id, $this->vehicle()?->id, $this->request->input('start_at'), $this->request->input('end_at'))
                ->list()
                ->get();
        });
    }

    /**
     * @return ?\App\Domains\City\Model\City
     */
    protected function city(): ?CityModel
    {
        return $this->cache(
            fn () => $this->cities()->firstWhere('id', $this->request->input('city_id'))
        );
    }

    /**
     * @return \App\Domains\Trip\Model\Collection\Trip
     */
    protected function list(): Collection
    {
        return $this->cache(
            fn () => Model::query()
                ->whenUserId($this->user()?->id)
                ->whenVehicleId($this->vehicle()?->id)
                ->whenDeviceId($this->device()?->id)
                ->whenStartUtcAtDateBetween($this->request->input('start_at'), $this->request->input('end_at'))
                ->whenCityStateCountry($this->city()?->id, $this->state()?->id, $this->country()?->id, $this->request->input('start_end'))
                ->whenPositionIdFrom($this->requestInteger('position_id_from'))
                ->whenFinished($this->requestBool('finished', null))
                ->withSimple('device')
                ->withSimple('user')
                ->withSimple('vehicle')
                ->withSimple('positions')
                ->listSimple()
                ->get()
        );
    }

    /**
     * @return array
     */
    protected function filterFinished(): array
    {
        return [
            '' => __('trip-map.filter-finished-all'),
            '0' => __('trip-map.filter-finished-no'),
            '1' => __('trip-map.filter-finished-yes'),
        ];
    }

    /**
     * @return bool
     */
    protected function show(): bool
    {
        return $this->request->input('_action') === 'show';
    }
}
