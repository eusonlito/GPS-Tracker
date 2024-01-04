<?php declare(strict_types=1);

namespace App\Domains\Position\Action;

use App\Domains\City\Model\City as CityModel;
use App\Domains\Position\Model\Position as Model;

class UpdateCity extends ActionAbstract
{
    /**
     * @var ?\App\Domains\City\Model\City
     */
    protected ?CityModel $city;

    /**
     * @return \App\Domains\Position\Model\Position
     */
    public function handle(): Model
    {
        if ($this->row->city_id) {
            return $this->row;
        }

        $this->city();
        $this->save();

        return $this->row;
    }

    /**
     * @return void
     */
    protected function city(): void
    {
        $this->city = $this->factory('City')->action($this->cityData())->getOrNew();
    }

    /**
     * @return array
     */
    protected function cityData(): array
    {
        return [
            'latitude' => $this->row->latitude,
            'longitude' => $this->row->longitude,
        ];
    }

    /**
     * @return void
     */
    protected function save(): void
    {
        if (empty($this->city)) {
            return;
        }

        $this->row->city_id = $this->city->id;
        $this->row->save();
    }
}
