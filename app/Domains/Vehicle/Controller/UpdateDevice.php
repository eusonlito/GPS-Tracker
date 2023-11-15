<?php declare(strict_types=1);

namespace App\Domains\Vehicle\Controller;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use App\Domains\Vehicle\Service\Controller\UpdateDevice as ControllerService;

class UpdateDevice extends ControllerAbstract
{
    /**
     * @param int $id
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function __invoke(int $id): Response|RedirectResponse
    {
        $this->row($id);

        if ($response = $this->actionPost('updateDevice')) {
            return $response;
        }

        $this->meta('title', __('vehicle-update-device.meta-title', ['title' => $this->row->name]));

        return $this->page('vehicle.update-device', $this->data());
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
    protected function updateDevice(): RedirectResponse
    {
        $this->action()->updateDevice();

        $this->sessionMessage('success', __('vehicle-update-device.success'));

        return redirect()->route('vehicle.update.device', $this->row->id);
    }
}
