<?php declare(strict_types=1);

namespace App\Domains\Alarm\Controller;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use App\Domains\Alarm\Service\Type\Manager as TypeManager;

class Update extends ControllerAbstract
{
    /**
     * @param int $id
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function __invoke(int $id): Response|RedirectResponse
    {
        $this->row($id);

        if ($response = $this->actions()) {
            return $response;
        }

        $this->requestMergeWithRow();

        $this->meta('title', $this->row->name);

        return $this->page('alarm.update', [
            'row' => $this->row,
            'alarm' => $this->alarm,
            'types' => TypeManager::new()->titles(),
            'type' => $this->alarm->type,
        ]);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|false|null
     */
    protected function actions(): RedirectResponse|false|null
    {
        return $this->actionPost('update')
            ?: $this->actionPost('delete');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function updateAlarmUpdate(): RedirectResponse
    {
        $this->action()->update();

        $this->sessionMessage('success', __('alarm-update.update-success'));

        return redirect()->route('alarm.update', $this->row->id);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function updateAlarmDelete(): RedirectResponse
    {
        $this->action()->delete();

        $this->sessionMessage('success', __('alarm-update.delete-success'));

        return redirect()->route('alarm.update', $this->row->id);
    }
}
