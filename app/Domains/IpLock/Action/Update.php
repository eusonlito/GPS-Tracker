<?php declare(strict_types=1);

namespace App\Domains\IpLock\Action;

class Update extends CreateUpdateAbstract
{
    /**
     * @return void
     */
    protected function save(): void
    {
        $this->row->ip = $this->data['ip'];
        $this->row->end_at = $this->data['end_at'];
        $this->row->save();
    }
}
