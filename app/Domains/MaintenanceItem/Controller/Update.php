<?php declare(strict_types=1);

namespace App\Domains\MaintenanceItem\Controller;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

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

        $this->meta('title', __('maintenance-item-update.meta-title', ['title' => $this->row->name]));

        return $this->page('maintenance-item.update', [
            'row' => $this->row,
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

        $this->sessionMessage('success', __('maintenance-item-update.success'));

        return redirect()->route('maintenance-item.update', $this->row->id);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function delete(): RedirectResponse
    {
        $this->action()->delete();

        $this->sessionMessage('success', __('maintenance-item-update.delete-success'));

        return redirect()->route('maintenance-item.index');
    }
}
