<?php declare(strict_types=1);

namespace App\Domains\Vehicle\Action;

use App\Domains\Alarm\Model\Alarm as AlarmModel;
use App\Domains\Vehicle\Model\Vehicle as Model;

class UpdateAlarm extends ActionAbstract
{
    /**
     * @return \App\Domains\Vehicle\Model\Vehicle
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
        $this->data['related'] = AlarmModel::query()
            ->byUserId($this->row->user_id)
            ->byIds($this->data['related'])
            ->pluck('id')
            ->all();
    }

    /**
     * @return void
     */
    protected function save(): void
    {
        $this->row->alarms()->sync($this->data['related']);
    }
}
