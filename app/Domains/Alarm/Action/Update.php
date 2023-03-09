<?php declare(strict_types=1);

namespace App\Domains\Alarm\Action;

class Update extends CreateUpdateAbstract
{
    /**
     * @return void
     */
    protected function type(): void
    {
        $this->type = $this->row->typeFormat($this->data['config']);
    }

    /**
     * @return void
     */
    protected function save(): void
    {
        $this->row->name = $this->data['name'];
        $this->row->config = $this->data['config'];
        $this->row->telegram = $this->data['telegram'];
        $this->row->enabled = $this->data['enabled'];
        $this->row->schedule_start = $this->data['schedule_start'];
        $this->row->schedule_end = $this->data['schedule_end'];

        $this->row->save();
    }
}
