<?php declare(strict_types=1);

namespace App\Domains\Country\Action;

use App\Domains\City\Model\City as CityModel;
use App\Domains\Country\Model\Country as Model;
use App\Domains\Country\Model\Collection\Country as Collection;
use App\Domains\State\Model\State as StateModel;

class UpdateMerge extends ActionAbstract
{
    /**
     * @var \App\Domains\Country\Model\Collection\Country
     */
    protected Collection $list;

    /**
     * @return \App\Domains\Country\Model\Country
     */
    public function handle(): Model
    {
        $this->list();
        $this->data();
        $this->check();
        $this->save();
        $this->delete();

        return $this->row;
    }

    /**
     * @return void
     */
    protected function list(): void
    {
        $this->list = Model::query()
            ->byIdNot($this->row->id)
            ->byIds($this->data['ids'])
            ->get();
    }

    /**
     * @return void
     */
    protected function data(): void
    {
        $this->dataIds();
        $this->dataAlias();
    }

    /**
     * @return void
     */
    protected function dataIds(): void
    {
        $this->data['ids'] = $this->list->pluck('id')->all();
    }

    /**
     * @return void
     */
    protected function dataAlias(): void
    {
        $this->data['alias'] = array_unique(array_filter(array_merge(
            (array)$this->row->alias,
            $this->list->pluck('name')->all(),
            ...array_filter($this->list->pluck('alias')->all())
        )));
    }

    /**
     * @return void
     */
    protected function check(): void
    {
        if ($this->list->isEmpty()) {
            $this->exceptionValidator(__('country-update-merge.error.ids-empty'));
        }
    }

    /**
     * @return void
     */
    protected function save(): void
    {
        $this->saveState();
        $this->saveCity();
        $this->saveRow();
    }

    /**
     * @return void
     */
    protected function saveState(): void
    {
        StateModel::query()
            ->byCountryIds($this->data['ids'])
            ->update(['country_id' => $this->row->id]);
    }

    /**
     * @return void
     */
    protected function saveCity(): void
    {
        CityModel::query()
            ->byCountryIds($this->data['ids'])
            ->update(['country_id' => $this->row->id]);
    }

    /**
     * @return void
     */
    protected function saveRow(): void
    {
        $this->row->alias = $this->data['alias'];
        $this->row->save();
    }

    /**
     * @return void
     */
    protected function delete(): void
    {
        Model::query()
            ->byIds($this->data['ids'])
            ->delete();
    }
}
