<?php declare(strict_types=1);

namespace App\Domains\Vehicle\Controller;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use App\Domains\Timezone\Model\Timezone as TimezoneModel;

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

        return $this->page('vehicle.update', [
            'row' => $this->row,
            'timezones' => TimezoneModel::query()->list()->get(),
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
    protected function update(): RedirectResponse
    {
        $this->action()->update();

        $this->sessionMessage('success', __('vehicle-update.success'));

        return redirect()->route('vehicle.update', $this->row->id);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function delete(): RedirectResponse
    {
        $this->action()->delete();

        $this->sessionMessage('success', __('vehicle-update.delete-success'));

        return redirect()->route('vehicle.index');
    }
}
