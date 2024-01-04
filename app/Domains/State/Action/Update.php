<?php declare(strict_types=1);

namespace App\Domains\State\Action;

use App\Domains\City\Model\City as CityModel;
use App\Domains\Country\Model\Country as CountryModel;
use App\Domains\State\Model\State as Model;

class Update extends ActionAbstract
{
    /**
     * @var bool
     */
    protected bool $relocate;

    /**
     * @return \App\Domains\State\Model\State
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
        $this->relocate = ($this->data['country_id'] !== $this->row->country_id);
    }

    /**
     * @return void
     */
    protected function data(): void
    {
        $this->dataAlias();
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
    protected function check(): void
    {
        $this->checkCountryId();
    }

    /**
     * @return void
     */
    protected function checkCountryId(): void
    {
        if ($this->checkCountryIdExists() === false) {
            $this->exceptionValidator(__('state-update.error.country-exists'));
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
        $this->saveRow();
        $this->saveCity();
    }

    /**
     * @return void
     */
    protected function saveRow(): void
    {
        $this->row->name = $this->data['name'];
        $this->row->alias = $this->data['alias'];
        $this->row->country_id = $this->data['country_id'];
        $this->row->save();
    }

    /**
     * @return void
     */
    protected function saveCity(): void
    {
        if ($this->relocate === false) {
            return;
        }

        CityModel::query()->byStateId($this->row->id)->update([
            'country_id' => $this->row->country_id,
        ]);
    }
}
