<?php

declare(strict_types=1);

namespace App\Domains\Role\Controller;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use App\Domains\Role\Service\Controller\UpdateVehicle as ControllerService;

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

        $this->meta('title', __('Role-update-vehicle.meta-title', ['title' => $this->row->name]));

        return $this->page('Role.update-vehicle', $this->data());
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

        $this->sessionMessage('success', __('Role-update-vehicle.success'));

        return redirect()->route('Role.update.vehicle', $this->row->id);
    }
}
