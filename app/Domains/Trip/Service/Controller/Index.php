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
    }

    /**
     * @return array
     */
    public function data(): array
    {
        return [
            'devices' => $this->devices(),
            'device' => $this->device(),
            'lasts' => $this->lasts(),
            'last' => $this->last(),
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
     * @return \Illuminate\Support\Collection
     */
    protected function devices(): Collection
    {
        return $this->cache[__FUNCTION__] ??= DeviceModel::byUserId($this->auth->id)->list()->get();
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
     * @return array
     */
    protected function lasts(): array
    {
        return $this->cache[__FUNCTION__] ??= [
            7 => __('trip-index.last-week'),
            30 => __('trip-index.last-month'),
            90 => __('trip-index.last-months', ['month' => 3]),
            180 => __('trip-index.last-months', ['month' => 6]),
            360 => __('trip-index.last-months', ['month' => 12]),
        ];
    }

    /**
     * @return ?int
     */
    protected function last(): ?int
    {
        if (isset($this->cache[__FUNCTION__])) {
            return $this->cache[__FUNCTION__];
        }

        $input = $this->request->input();
        $lasts = array_keys($this->lasts());
        $last = $input['last'] ?? null;

        if (array_key_exists('last', $input) === false) {
            $last = $lasts[0];
        } elseif (empty($last)) {
            $last = null;
        } else {
            $last = intval(in_array($last, $lasts) ? $last : $lasts[0]);
        }

        $this->request->merge(['last' => $last]);

        return $this->cache[__FUNCTION__] = $last;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    protected function countries(): Collection
    {
        return $this->cache[__FUNCTION__] ??= CountryModel::list()->get();
    }

    /**
     * @return ?\App\Domains\Country\Model\Country
     */
    protected function country(): ?CountryModel
    {
        return $this->cache[__FUNCTION__] ??= $this->countries()->firstWhere('id', $this->request->input('country_id'));
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    protected function states(): Collection
    {
        if (empty($country_id = intval($this->country()?->id))) {
            return collect();
        }

        return $this->cache[__FUNCTION__] ??= StateModel::byCountryId($country_id)
            ->byUserIdAndDays($this->auth->id, $this->last())
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

        return $this->cache[__FUNCTION__] ??= CityModel::byStateId($state_id)
            ->byUserIdAndDays($this->auth->id, $this->last())
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
     * @return \Illuminate\Support\Collection
     */
    protected function list(): Collection
    {
        return $this->cache[__FUNCTION__] ??= Model::byUserId($this->auth->id)
            ->whenLastDays($this->last())
            ->whenCityStateCountry($this->city()?->id, $this->state()?->id, $this->country()?->id)
            ->list()
            ->get();
    }
}
