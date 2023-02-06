<?php declare(strict_types=1);

namespace App\Domains\AlarmNotification\Controller;

use Illuminate\Http\RedirectResponse;

class Delete extends ControllerAbstract
{
    /**
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(int $id): RedirectResponse
    {
        $this->row($id);

        $this->actionCall('delete');

        return redirect()->back();
    }

    /**
     * @return void
     */
    protected function delete(): void
    {
        $this->sessionMessage('success', __('alarm-notification-update.delete-success'));

        $this->factory()->action()->delete();
    }
}
