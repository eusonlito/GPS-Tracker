<?php declare(strict_types=1);

namespace App\Domains\Trip\Service\Controller;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use App\Domains\City\Model\City as CityModel;
use App\Domains\City\Model\Collection\City as CityCollection;
use App\Domains\Country\Model\Collection\Country as CountryCollection;
use App\Domains\Country\Model\Country as CountryModel;
use App\Domains\Device\Model\Collection\Device as DeviceCollection;
use App\Domains\Device\Model\Device as DeviceModel;
use App\Domains\State\Model\Collection\State as StateCollection;
use App\Domains\State\Model\State as StateModel;
use App\Domains\Trip\Model\Collection\Trip as Collection;
use App\Domains\Trip\Model\Trip as Model;
use App\Domains\Vehicle\Model\Collection\Vehicle as VehicleCollection;
use App\Domains\Vehicle\Model\Vehicle as VehicleModel;

class Index extends ControllerAbstract
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
        $this->filtersDates();
        $this->filtersIds();
    }

    /**
     * @return void
     */
    protected function filtersDates(): void
    {
        if (preg_match('/^[0-9]{4}\-[0-9]{2}\-[0-9]{2}$/', (string)$this->request->input('start_at')) === 0) {
            $this->request->merge(['start_at' => date('Y-m-d', strtotime('-30 days'))]);
        }

        if (preg_match('/^[0-9]{4}\-[0-9]{2}\-[0-9]{2}$/', (string)$this->request->input('end_at')) === 0) {
            $this->request->merge(['end_at' => '']);
        }
    }

    /**
     * @return void
     */
    protected function filtersIds(): void
    {
        $this->request->merge([
            'vehicle_id' => $this->auth->preference('vehicle_id', $this->request->input('vehicle_id')),
            'device_id' => $this->auth->preference('device_id', $this->request->input('device_id')),
        ]);
    }

    /**
     * @return array
     */
    public function data(): array
    {
        return [
            'vehicles' => $this->vehicles(),
            'vehicles_multiple' => ($this->vehicles()->count() > 1),
            'vehicle' => $this->vehicle(),
            'devices' => $this->devices(),
            'devices_multiple' => ($this->devices()->count() > 1),
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
            'list' => $this->list(),
        ];
    }

    /**
     * @return \App\Domains\Vehicle\Model\Collection\Vehicle
     */
    protected function vehicles(): VehicleCollection
    {
        return $this->cache[__FUNCTION__] ??= VehicleModel::query()
            ->byUserId($this->auth->id)
            ->list()
            ->get();
    }

    /**
     * @return \App\Domains\Vehicle\Model\Vehicle
     */
    protected function vehicle(): VehicleModel
    {
        return $this->cache[__FUNCTION__] ??= $this->vehicles()->firstWhere('id', $this->request->input('vehicle_id'))
            ?: $this->vehicles()->first();
    }

    /**
     * @return \App\Domains\Device\Model\Collection\Device
     */
    protected function devices(): DeviceCollection
    {
        return $this->cache[__FUNCTION__] ??= $this->vehicle()->devices()->list()->get();
    }

    /**
     * @return ?\App\Domains\Device\Model\Device
     */
    protected function device(): ?DeviceModel
    {
        return $this->cache[__FUNCTION__] ??= $this->devices()->firstWhere('id', $this->request->input('device_id'))
            ?: $this->devices()->first();
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
        return $this->cache[__FUNCTION__] ??= $this->states()->firstWhere('id', $this->request->input('state_id'));
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
        return $this->cache[__FUNCTION__] ??= $this->cities()->firstWhere('id', $this->request->input('city_id'));
    }

    /**
     * @return ?string
     */
    protected function dateMin(): ?string
    {
        return Model::query()->byVehicleId($this->vehicle()->id)->orderByStartAtAsc()->rawValue('DATE(`start_utc_at`)');
    }

    /**
     * @return array
     */
    protected function startsEnds(): array
    {
        return [
            'start' => __('trip-index.start'),
            'end' => __('trip-index.end'),
        ];
    }

    /**
     * @return array
     */
    protected function shared(): array
    {
        return [
            '' => __('trip-index.shared-all'),
            '1' => __('trip-index.shared-yes'),
            '0' => __('trip-index.shared-no'),
        ];
    }

    /**
     * @return \App\Domains\Trip\Model\Collection\Trip
     */
    protected function list(): Collection
    {
        return $this->cache[__FUNCTION__] ??= Model::query()
            ->selectSimple()
            ->byVehicleId($this->vehicle()->id)
            ->whenDeviceId($this->device()->id ?? null)
            ->whenStartUtcAtDateBeforeAfter($this->request->input('end_at'), $this->request->input('start_at'))
            ->whenCityStateCountry($this->city()?->id, $this->state()?->id, $this->country()?->id, $this->request->input('start_end'))
            ->whenShared($this->listWhenShared())
            ->withDevice()
            ->withVehicle()
            ->list()
            ->get();
    }

    /**
     * @return ?bool
     */
    protected function listWhenShared(): ?bool
    {
        return match ($shared = $this->request->input('shared')) {
            '1', '0' => boolval($shared),
            default => null,
        };
    }
}
