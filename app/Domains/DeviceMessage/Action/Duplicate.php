<?php declare(strict_types=1);

namespace App\Domains\DeviceMessage\Action;

use App\Domains\DeviceMessage\Model\DeviceMessage as Model;

class Duplicate extends ActionAbstract
{
    /**
     * @return \App\Domains\DeviceMessage\Model\DeviceMessage
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
        $this->row = Model::query()->create([
            'message' => $this->row->message,
            'device_id' => $this->row->device_id,
        ]);
    }
}
