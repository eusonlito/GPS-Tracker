<?php declare(strict_types=1);

namespace App\Domains\Device\Controller;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use App\Domains\Alarm\Service\Type\Manager as AlarmTypeManager;
use App\Domains\Position\Model\Position as PositionModel;

class UpdateAlarmCreate extends ControllerAbstract
{
    /**
     * @param int $id
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function __invoke(int $id): Response|RedirectResponse
    {
        $this->row($id);

        if ($response = $this->actionPost('updateAlarmCreate')) {
            return $response;
        }

        $typeService = AlarmTypeManager::new();

        $this->meta('title', $this->row->name);

        return $this->page('device.update-alarm-create', [
            'row' => $this->row,
            'types' => $typeService->titles(),
            'type' => $typeService->selected($this->request->input('type')),
            'position' => PositionModel::query()->byUserId($this->auth->id)->orderByDateUtcAtDesc()->first(),
        ]);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function updateAlarmCreate(): RedirectResponse
    {
        $this->action()->updateAlarmCreate();

        $this->sessionMessage('success', __('device-update-alarm.create-success'));

        return redirect()->route('device.update.alarm', $this->row->id);
    }
}
