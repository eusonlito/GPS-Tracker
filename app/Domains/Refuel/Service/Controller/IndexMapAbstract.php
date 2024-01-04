<?php declare(strict_types=1);

namespace App\Domains\Refuel\Service\Controller;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use App\Domains\City\Model\City as CityModel;
use App\Domains\City\Model\Collection\City as CityCollection;
use App\Domains\Country\Model\Collection\Country as CountryCollection;
use App\Domains\Country\Model\Country as CountryModel;
use App\Domains\Refuel\Model\Refuel as Model;
use App\Domains\State\Model\Collection\State as StateCollection;
use App\Domains\State\Model\State as StateModel;

abstract class IndexMapAbstract extends ControllerAbstract
{
    /**
     * @const string
     */
    protected const DATE_REGEXP = '/^[0-9]{4}\-[0-9]{2}\-[0-9]{2}$/';

    /**
     * @var bool
     */
    protected bool $userEmpty = true;

    /**
     * @var bool
     */
    protected bool $vehicleEmpty = true;

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
        $this->filtersDatesStartAt();
        $this->filtersDatesEndAt();
    }

    /**
     * @return void
     */
    protected function filtersDatesStartAt(): void
    {
        $start_at = $this->request->input('start_at');

        if ($start_at === '') {
            return;
        }

        if (is_null($start_at) || (preg_match(static::DATE_REGEXP, $start_at) === 0)) {
            $this->request->merge(['start_at' => date('Y-m-d', strtotime('-1 year'))]);
        }
    }

    /**
     * @return void
     */
    protected function filtersDatesEndAt(): void
    {
        $end_at = $this->request->input('end_at');

        if (is_null($end_at) || (preg_match(static::DATE_REGEXP, $end_at) === 0)) {
            $this->request->merge(['end_at' => '']);
        }
    }

    /**
     * @return void
     */
    protected function filtersIds(): void
    {
        $this->filtersUserId();
        $this->filtersVehicleId();
    }

    /**
     * @return ?string
     */
    protected function dateMin(): ?string
    {
        return $this->cache(
            fn () => Model::query()
                ->whenUserId($this->user()?->id)
                ->orderByDateAtAsc()
                ->rawValue('DATE(`date_at`)')
        );
    }

    /**
     * @return \App\Domains\Country\Model\Collection\Country
     */
    protected function countries(): CountryCollection
    {
        return $this->cache(function () {
            return CountryModel::query()
                ->whenRefuelUserIdVehicleIdDateAtBetween($this->user()?->id, $this->vehicle()?->id, $this->request->input('start_at'), $this->request->input('end_at'))
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
                ->whenRefuelUserIdVehicleIdDateAtBetween($this->user()?->id, $this->vehicle()?->id, $this->request->input('start_at'), $this->request->input('end_at'))
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
                ->whenRefuelUserIdVehicleIdDateAtBetween($this->user()?->id, $this->vehicle()?->id, $this->request->input('start_at'), $this->request->input('end_at'))
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
}
