<?php declare(strict_types=1);

namespace App\Domains\Device\Action;

use App\Domains\Alarm\Model\Alarm as AlarmModel;

class UpdateAlarmCreate extends ActionAbstract
{
    /**
     * @var \App\Domains\Alarm\Model\Alarm
     */
    protected AlarmModel $alarm;

    /**
     * @return \App\Domains\Alarm\Model\Alarm
     */
    public function handle(): AlarmModel
    {
        $this->save();

        return $this->alarm;
    }

    /**
     * @return void
     */
    protected function save(): void
    {
        $this->alarm = $this->factory('Alarm')->action($this->saveData())->create();
    }

    /**
     * @return array
     */
    protected function saveData(): array
    {
        return ['device_id' => $this->row->id] + $this->request->input();
    }
}
