<?php declare(strict_types=1);

namespace App\Domains\Device\Controller;

use Illuminate\Http\JsonResponse;
use App\Domains\Alarm\Model\Alarm as AlarmModel;

class UpdateAlarmUpdateBoolean extends ControllerAbstract
{
    /**
     * @param int $id
     * @param int $alarm_id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(int $id, int $alarm_id): JsonResponse
    {
        $this->row($id);
        $this->alarm($alarm_id);

        return $this->json($this->fractal($this->actionCall('execute')));
    }

    /**
     * @return \App\Domains\Alarm\Model\Alarm
     */
    protected function execute(): AlarmModel
    {
        return $this->factory('Alarm', $this->alarm)->action()->updateBoolean();
    }

    /**
     * @param \App\Domains\Alarm\Model\Alarm $alarm
     *
     * @return array
     */
    protected function fractal(AlarmModel $alarm): array
    {
        return $this->factory('Alarm')->fractal('simple', $alarm);
    }
}
