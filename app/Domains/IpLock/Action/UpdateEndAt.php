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
        $this->data();
        $this->save();

        return $this->row;
    }

    /**
     * @return void
     */
    protected function data(): void
    {
        $this->dataEndAt();
    }

    /**
     * @return void
     */
    protected function dataEndAt(): void
    {
        if ($this->row->end_at) {
            $this->data['end_at'] = min(date('Y-m-d H:i:s'), $this->row->end_at);
        } else {
            $this->data['end_at'] = date('Y-m-d H:i:s');
        }
    }

    /**
     * @return void
     */
    protected function save(): void
    {
        $this->row->end_at = $this->data['end_at'];
        $this->row->save();
    }
}
