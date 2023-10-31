<?php declare(strict_types=1);

namespace App\Domains\Alarm\Controller;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use App\Domains\Alarm\Service\Controller\UpdateVehicle as ControllerService;

class UpdateVehicle extends ControllerAbstract
{
    /**
     * @param int $id
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function __invoke(int $id): Response|RedirectResponse
    {
        $this->row($id);

        if ($response = $this->actionPost('updateVehicle')) {
            return $response;
        }

        $this->meta('title', __('alarm-update-vehicle.meta-title', ['title' => $this->row->name]));

        return $this->page('alarm.update-vehicle', $this->data());
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
    protected function updateVehicle(): RedirectResponse
    {
        $this->action()->updateVehicle();

        $this->sessionMessage('success', __('alarm-update-vehicle.success'));

        return redirect()->route('alarm.update.vehicle', $this->row->id);
    }
}
