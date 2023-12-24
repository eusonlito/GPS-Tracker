<?php declare(strict_types=1);

namespace App\Domains\City\Action;

use App\Domains\City\Model\City as Model;
use App\Domains\Country\Model\Country as CountryModel;
use App\Domains\State\Model\State as StateModel;
use App\Services\Locate\LocateFactory;
use App\Services\Locate\Resource as LocateResource;

class GetOrNew extends ActionAbstract
{
    /**
     * @var ?\App\Services\Locate\Resource
     */
    protected ?LocateResource $locate;

    /**
     * @var \App\Domains\Country\Model\Country
     */
    protected CountryModel $country;

    /**
     * @var \App\Domains\State\Model\State
     */
    protected StateModel $state;

    /**
     * @return ?\App\Domains\City\Model\City
     */
    public function handle(): ?Model
    {
        $this->locate();

        if ($this->locateIsValid() === false) {
            return $this->near();
        }

        $this->country();
        $this->state();
        $this->row();

        return $this->row;
    }

    /**
     * @return void
     */
    protected function locate(): void
    {
        $this->locate = LocateFactory::new($this->data['latitude'], $this->data['longitude'])->locate();
    }

    /**
     * @return bool
     */
    protected function locateIsValid(): bool
    {
        return $this->locate
            && $this->locate->city
            && $this->locate->state
            && $this->locate->country;
    }

    /**
     * @return ?\App\Domains\City\Model\City
     */
    protected function near(): ?Model
    {
        return Model::query()
            ->selectDistance($this->data['latitude'], $this->data['longitude'])
            ->byDistanceMax(1000)
            ->orderByDistance()
            ->first();
    }

    /**
     * @return void
     */
    protected function country(): void
    {
        $this->country = $this->factory('Country')->action($this->countryData())->getOrNew();
    }

    /**
     * @return array
     */
    protected function countryData(): array
    {
        return [
            'name' => $this->locate->country,
            'code' => $this->locate->country_code,
        ];
    }

    /**
     * @return void
     */
    protected function state(): void
    {
        $this->state = $this->factory('State')->action($this->stateData())->getOrNew();
    }

    /**
     * @return array
     */
    protected function stateData(): array
    {
        return [
            'name' => $this->locate->state,
            'country_id' => $this->country->id,
        ];
    }

    /**
     * @return void
     */
    protected function row(): void
    {
        $this->row = $this->rowByName()
            ?: $this->rowByAlias()
            ?: $this->rowByCreate();
    }

    /**
     * @return ?\App\Domains\City\Model\City
     */
    protected function rowByName(): ?Model
    {
        return Model::query()
            ->byName($this->locate->city)
            ->byStateId($this->state->id)
            ->byCountryId($this->country->id)
            ->first();
    }

    /**
     * @return ?\App\Domains\City\Model\City
     */
    protected function rowByAlias(): ?Model
    {
        return Model::query()
            ->byAlias($this->locate->city)
            ->byStateId($this->state->id)
            ->byCountryId($this->country->id)
            ->first();
    }

    /**
     * @return \App\Domains\City\Model\City
     */
    protected function rowByCreate(): Model
    {
        return Model::query()->create([
            'name' => $this->locate->city,
            'state_id' => $this->state->id,
            'country_id' => $this->country->id,
            'point' => Model::pointFromLatitudeLongitude($this->data['latitude'], $this->data['longitude']),
        ]);
    }
}
