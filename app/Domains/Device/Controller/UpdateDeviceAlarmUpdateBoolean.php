<?php declare(strict_types=1);

namespace App\Domains\Device\Controller;

use Illuminate\Http\JsonResponse;
use App\Domains\DeviceAlarm\Model\DeviceAlarm as DeviceAlarmModel;

class UpdateDeviceAlarmUpdateBoolean extends ControllerAbstract
{
    /**
     * @param int $id
     * @param int $device_alarm_id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(int $id, int $device_alarm_id): JsonResponse
    {
        $this->row($id);
        $this->alarm($device_alarm_id);

        return $this->json($this->fractal($this->execute()));
    }

    /**
     * @return \App\Domains\DeviceAlarm\Model\DeviceAlarm
     */
    protected function execute(): DeviceAlarmModel
    {
        return $this->factory('DeviceAlarm', $this->alarm)->action()->updateBoolean();
    }

    /**
     * @param \App\Domains\DeviceAlarm\Model\DeviceAlarm $alarm
     *
     * @return array
     */
    protected function fractal(DeviceAlarmModel $alarm): array
    {
        return $this->factory('DeviceAlarm')->fractal('simple', $alarm);
    }
}
