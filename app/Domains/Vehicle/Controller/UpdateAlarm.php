<?php declare(strict_types=1);

namespace App\Domains\Vehicle\Controller;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use App\Domains\Vehicle\Service\Controller\UpdateAlarm as ControllerService;

class UpdateAlarm extends ControllerAbstract
{
    /**
     * @param int $id
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function __invoke(int $id): Response|RedirectResponse
    {
        $this->row($id);

        if ($response = $this->actionPost('updateAlarm')) {
            return $response;
        }

        $this->meta('title', __('vehicle-update-alarm.meta-title', ['title' => $this->row->name]));

        return $this->page('vehicle.update-alarm', $this->data());
    }

    /**
     * @return array
     */
    protected function data(): array
    {
        return ControllerService::new($this->request, $this->auth, $this->row)->data();
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function updateAlarm(): RedirectResponse
    {
        $this->action()->updateAlarm();

        $this->sessionMessage('success', __('vehicle-update-alarm.success'));

        return redirect()->route('vehicle.update.alarm', $this->row->id);
    }
}
