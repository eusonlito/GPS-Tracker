<?php declare(strict_types=1);

namespace App\Domains\State\Action;

use App\Domains\Country\Model\Country as CountryModel;
use App\Domains\State\Model\State as Model;

class GetOrNew extends ActionAbstract
{
    /**
     * @var \App\Domains\Country\Model\Country
     */
    protected CountryModel $country;

    /**
     * @return \App\Domains\State\Model\State
     */
    public function handle(): Model
    {
        $this->country();
        $this->row();

        return $this->row;
    }

    /**
     * @return void
     */
    protected function country(): void
    {
        $this->country = CountryModel::query()
            ->findOrFail($this->data['country_id']);
    }

    /**
     * @return void
     */
    protected function row(): void
    {
        $this->row = Model::query()->firstOrCreate([
            'name' => $this->data['name'],
            'country_id' => $this->country->id,
        ]);
    }
}
