<?php declare(strict_types=1);

namespace App\Domains\Alarm\Controller;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use App\Domains\Alarm\Service\Type\Manager as TypeManager;
use App\Domains\Position\Model\Position as PositionModel;

class Create extends ControllerAbstract
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

        $typeService = TypeManager::new();

        $this->meta('title', __('alarm-create.meta-title'));

        return $this->page('alarm.create', [
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
        $this->action()->create();

        $this->sessionMessage('success', __('alarm-create.success'));

        return redirect()->route('alarm.update', $this->row->id);
    }
}
