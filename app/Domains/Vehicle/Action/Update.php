<?php declare(strict_types=1);

namespace App\Domains\Vehicle\Action;

class Update extends CreateUpdateAbstract
{
    /**
     * @return void
     */
    protected function save(): void
    {
        $this->row->name = $this->data['name'];
        $this->row->plate = $this->data['plate'];
        $this->row->timezone_auto = $this->data['timezone_auto'];
        $this->row->enabled = $this->data['enabled'];
        $this->row->timezone_id = $this->data['timezone_id'];

        $this->row->save();
    }
}
