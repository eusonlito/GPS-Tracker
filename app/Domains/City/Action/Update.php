<?php declare(strict_types=1);

namespace App\Domains\City\Action;

use App\Domains\City\Model\City as Model;
use App\Domains\Country\Model\Country as CountryModel;
use App\Domains\State\Model\State as StateModel;

class Update extends ActionAbstract
{
    /**
     * @var bool
     */
    protected bool $relocate;

    /**
     * @return \App\Domains\City\Model\City
     */
    public function handle(): Model
    {
        $this->relocate();
        $this->data();
        $this->check();
        $this->save();

        return $this->row;
    }

    /**
     * @return void
     */
    protected function relocate(): void
    {
        $this->relocate = ($this->data['state_id'] !== $this->row->state_id)
            || ($this->data['country_id'] !== $this->row->country_id);
    }

    /**
     * @return void
     */
    protected function data(): void
    {
        $this->dataAlias();
        $this->dataPoint();
    }

    /**
     * @return void
     */
    protected function dataAlias(): void
    {
        $this->data['alias'] = array_filter(array_map('trim', explode(',', $this->data['alias'])));
    }

    /**
     * @return void
     */
    protected function dataPoint(): void
    {
        $this->data['point'] = Model::pointFromLatitudeLongitude(
            round($this->data['latitude'], 5),
            round($this->data['longitude'], 5),
        );
    }

    /**
     * @return void
     */
    protected function check(): void
    {
        $this->checkStateId();
        $this->checkCountryId();
    }

    /**
     * @return void
     */
    protected function checkStateId(): void
    {
        if ($this->checkStateIdExists() === false) {
            $this->exceptionValidator(__('city-update.error.state-exists'));
        }
    }

    /**
     * @return bool
     */
    protected function checkStateIdExists(): bool
    {
        return StateModel::query()
            ->byId($this->data['state_id'])
            ->exists();
    }

    /**
     * @return void
     */
    protected function checkCountryId(): void
    {
        if ($this->checkCountryIdExists() === false) {
            $this->exceptionValidator(__('city-update.error.country-exists'));
        }
    }

    /**
     * @return bool
     */
    protected function checkCountryIdExists(): bool
    {
        return CountryModel::query()
            ->byId($this->data['country_id'])
            ->exists();
    }

    /**
     * @return void
     */
    protected function save(): void
    {
        $this->row->name = $this->data['name'];
        $this->row->alias = $this->data['alias'];
        $this->row->point = $this->data['point'];
        $this->row->state_id = $this->data['state_id'];
        $this->row->country_id = $this->data['country_id'];
        $this->row->save();
    }
}
