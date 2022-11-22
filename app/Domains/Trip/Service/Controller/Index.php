<?php declare(strict_types=1);

namespace App\Domains\Trip\Service\Controller;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Domains\City\Model\City as CityModel;
use App\Domains\Country\Model\Country as CountryModel;
use App\Domains\Device\Model\Device as DeviceModel;
use App\Domains\State\Model\State as StateModel;
use App\Domains\Trip\Model\Trip as Model;

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
     * @return array
     */
    public function data(): array
    {
        return [
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
            'list' => $this->list(),
        ];
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    protected function devices(): Collection
    {
        return $this->cache[__FUNCTION__] ??= DeviceModel::query()
            ->byUserId($this->auth->id)
            ->list()
            ->get();
    }

    /**
     * @return \App\Domains\Device\Model\Device
     */
    protected function device(): DeviceModel
    {
        return $this->cache[__FUNCTION__] ??= $this->devices()->firstWhere('id', $this->request->input('device_id'))
            ?: $this->devices()->first();
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    protected function countries(): Collection
    {
        return $this->cache[__FUNCTION__] ??= CountryModel::query()
            ->byDeviceIdWhenTripStartUtcAtDateBeforeAfter($this->device()->id, $this->request->input('end_at'), $this->request->input('start_at'), $this->request->input('start_end'))
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
     * @return \Illuminate\Support\Collection
     */
    protected function states(): Collection
    {
        if (empty($country_id = intval($this->country()?->id))) {
            return collect();
        }

        return $this->cache[__FUNCTION__] ??= StateModel::query()
            ->byCountryId($country_id)
            ->byDeviceIdWhenTripStartUtcAtDateBeforeAfter($this->device()->id, $this->request->input('end_at'), $this->request->input('start_at'), $this->request->input('start_end'))
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
     * @return \Illuminate\Support\Collection
     */
    protected function cities(): Collection
    {
        if (empty($state_id = intval($this->state()?->id))) {
            return collect();
        }

        return $this->cache[__FUNCTION__] ??= CityModel::query()
            ->byStateId($state_id)
            ->byDeviceIdWhenTripStartUtcAtDateBeforeAfter($this->device()->id, $this->request->input('end_at'), $this->request->input('start_at'), $this->request->input('start_end'))
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
        return Model::query()->byDeviceId($this->device()->id)->orderByStartAtAsc()->rawValue('DATE(`start_utc_at`)');
    }

    /**
     * @return array
     */
    protected function startsEnds(): array
    {
        return $this->cache[__FUNCTION__] ??= [
            'start' => __('trip-index.start'),
            'end' => __('trip-index.end'),
        ];
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    protected function list(): Collection
    {
        return $this->cache[__FUNCTION__] ??= Model::query()
            ->byDeviceId($this->device()->id)
            ->whenStartUtcAtDateBeforeAfter($this->request->input('end_at'), $this->request->input('start_at'))
            ->whenCityStateCountry($this->city()?->id, $this->state()?->id, $this->country()?->id, $this->request->input('start_end'))
            ->withDevice()
            ->list()
            ->get();
    }
}
