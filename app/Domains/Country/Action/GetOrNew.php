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
        $this->row = $this->rowByName()
            ?: $this->rowByAlias()
            ?: $this->rowByCreate();
    }

    /**
     * @return ?\App\Domains\Country\Model\Country
     */
    protected function rowByName(): ?Model
    {
        return Model::query()
            ->byCode($this->data['code'])
            ->first();
    }

    /**
     * @return ?\App\Domains\Country\Model\Country
     */
    protected function rowByAlias(): ?Model
    {
        return Model::query()
            ->byAlias($this->data['name'])
            ->first();
    }

    /**
     * @return \App\Domains\Country\Model\Country
     */
    protected function rowByCreate(): Model
    {
        return Model::query()->create([
            'code' => $this->data['code'],
            'name' => $this->data['name'],
        ]);
    }
}
