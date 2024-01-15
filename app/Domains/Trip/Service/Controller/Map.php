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
            'user_show' => $this->userShow(),
            'vehicles' => $this->vehicles(),
            'vehicles_multiple' => $this->vehiclesMultiple(),
            'vehicle' => $this->vehicle(),
            'vehicle_show' => $this->vehicleShow(),
            'devices' => $this->devices(),
            'devices_multiple' => $this->devicesMultiple(),
            'device' => $this->device(),
            'device_show' => $this->deviceShow(),
            'countries' => $this->countries(),
            'country' => $this->country(),
            'states' => $this->states(),
            'state' => $this->state(),
            'cities' => $this->cities(),
            'city' => $this->city(),
            'date_min' => $this->dateMin(),
            'starts_ends' => $this->startsEnds(),
            'filter_finished' => $this->filterFinished(),
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
     * @return bool
     */
    public function userShow(): bool
    {
        return empty($this->user()) && (count($this->users()) > 1);
    }

    /**
     * @return bool
     */
    public function vehicleShow(): bool
    {
        return empty($this->vehicle()) && (count($this->vehicles()) > 1);
    }

    /**
     * @return bool
     */
    public function deviceShow(): bool
    {
        return empty($this->device()) && (count($this->devices()) > 1);
    }

    /**
     * @return \App\Domains\Country\Model\Collection\Country
     */
    protected function countries(): CountryCollection
    {
        return $this->cache(function () {
            return CountryModel::query()
                ->whenTripUserIdVehicleIdStartAtBetween($this->user()?->id, $this->vehicle()?->id, $this->request->input('start_at'), $this->request->input('end_at'))
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
                ->whenTripUserIdVehicleIdStartAtBetween($this->user()?->id, $this->vehicle()?->id, $this->request->input('start_at'), $this->request->input('end_at'))
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
                ->whenTripUserIdVehicleIdStartAtBetween($this->user()?->id, $this->vehicle()?->id, $this->request->input('start_at'), $this->request->input('end_at'))
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
                ->whenStartAtDateBetween($this->request->input('start_at'), $this->request->input('end_at'))
                ->whenCityStateCountry($this->city()?->id, $this->state()?->id, $this->country()?->id, $this->request->input('start_end'))
                ->whenPositionIdFrom($this->requestInteger('position_id_from'))
                ->whenFinished($this->requestBool('finished', null))
                ->withSimpleWhen('device', $this->device() === null)
                ->withSimpleWhen('user', $this->user() === null)
                ->withSimpleWhen('vehicle', $this->vehicle() === null)
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
}
