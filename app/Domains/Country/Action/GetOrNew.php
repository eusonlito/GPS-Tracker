<?php declare(strict_types=1);

namespace App\Domains\Country\Action;

use App\Domains\Country\Model\Country as Model;

class GetOrNew extends ActionAbstract
{
    /**
     * @return \App\Domains\Country\Model\Country
     */
    public function handle(): Model
    {
        $this->row();

        return $this->row;
    }

    /**
     * @return void
     */
    protected function row(): void
    {
        $this->row = Model::query()->firstOrCreate(
            ['code' => $this->data['code']],
            ['name' => $this->data['name']],
        );
    }
}
