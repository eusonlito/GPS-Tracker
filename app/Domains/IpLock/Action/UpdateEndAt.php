<?php declare(strict_types=1);

namespace App\Domains\IpLock\Action;

use App\Domains\IpLock\Model\IpLock as Model;

class UpdateEndAt extends ActionAbstract
{
    /**
     * @return \App\Domains\IpLock\Model\IpLock
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
        $this->row->end_at = min(date('Y-m-d H:i:s'), $this->row->end_at);
        $this->row->save();
    }
}
