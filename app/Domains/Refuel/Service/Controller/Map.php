<?php declare(strict_types=1);

namespace App\Domains\Refuel\Service\Controller;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use App\Domains\City\Model\City as CityModel;
use App\Domains\City\Model\Collection\City as CityCollection;
use App\Domains\Country\Model\Collection\Country as CountryCollection;
use App\Domains\Country\Model\Country as CountryModel;
use App\Domains\Refuel\Model\Collection\Refuel as Collection;
use App\Domains\Refuel\Model\Refuel as Model;
use App\Domains\State\Model\Collection\State as StateCollection;
use App\Domains\State\Model\State as StateModel;

class Map extends ControllerAbstract
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Contracts\Auth\Authenticatable $auth
     *
     * @return self
     */
    public function __construct(protected Request $request, protected Authenticatable $auth)
    {
        $this->filters();
    }

    /**
     * @return void
     */
    protected function filters(): void
    {
        $this->request->merge([
            'user_id' => $this->auth->preference('user_id', $this->request->input('user_id')),
            'vehicle_id' => $this->auth->preference('vehicle_id', $this->request->input('vehicle_id')),
        ]);
    }

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
            'list' => $this->list(),
        ];
    }

    /**
     * @return \App\Domains\Country\Model\Collection\Country
     */
    protected function countries(): CountryCollection
    {
        return $this->cache(function () {
            return CountryModel::query()
                ->whenRefuelUserIdVehicleIdDateAtBetween($this->user()?->id, $this->vehicle()?->id, $this->request->input('start_at'), $this->request->input('end_at'), $this->request->input('start_end'))
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
                ->whenRefuelUserIdVehicleIdDateAtBetween($this->user()?->id, $this->vehicle()?->id, $this->request->input('start_at'), $this->request->input('end_at'), $this->request->input('start_end'))
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
                ->whenRefuelUserIdVehicleIdDateAtBetween($this->user()?->id, $this->vehicle()?->id, $this->request->input('start_at'), $this->request->input('end_at'), $this->request->input('start_end'))
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
     * @return \App\Domains\Refuel\Model\Collection\Refuel
     */
    protected function list(): Collection
    {
        return $this->cache(
            fn () => Model::query()
                ->whenCityStateCountryId($this->city()?->id, $this->state()?->id, $this->country()?->id)
                ->whenUserId($this->user()?->id)
                ->whenVehicleId($this->vehicle()?->id)
                ->withWhereHasPosition()
                ->withVehicle()
                ->list()
                ->get()
        );
    }
}
