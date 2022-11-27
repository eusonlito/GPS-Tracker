<?php declare(strict_types=1);

namespace App\Domains\Timezone\Action;

use App\Domains\Timezone\Model\Timezone as Model;

class UpdateDefault extends ActionAbstract
{
    /**
     * @return \App\Domains\Timezone\Model\Timezone
     */
    public function handle(): Model
    {
        $this->save();

        return $this->row;
    }

    /**
     * @return void
     */
    protected function save(): void
    {
        $this->saveRow();
        $this->saveOthers();
    }

    /**
     * @return void
     */
    protected function saveRow(): void
    {
        $this->row->default = true;
        $this->row->save();
    }

    /**
     * @return void
     */
    protected function saveOthers(): void
    {
        Model::query()
            ->byIdNot($this->row->id)
            ->whereDefault()
            ->update(['default' => false]);
    }
}
