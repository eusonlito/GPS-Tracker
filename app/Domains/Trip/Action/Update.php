<?php declare(strict_types=1);

namespace App\Domains\Trip\Action;

use App\Domains\Trip\Model\Trip as Model;

class Update extends ActionAbstract
{
    /**
     * @return \App\Domains\Trip\Model\Trip
     */
    public function handle(): Model
    {
        $this->data();
        $this->save();

        return $this->row;
    }

    /**
     * @return void
     */
    protected function data(): void
    {
        $this->dataCode();
    }

    /**
     * @return void
     */
    protected function dataCode(): void
    {
        $this->data['code'] = $this->row->code ?: helper()->uuid();
    }

    /**
     * @return void
     */
    protected function save(): void
    {
        $this->row->name = $this->data['name'];
        $this->row->code = $this->data['code'];
        $this->row->shared = $this->data['shared'];
        $this->row->save();
    }
}
