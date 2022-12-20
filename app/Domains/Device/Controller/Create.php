<?php declare(strict_types=1);

namespace App\Domains\Device\Controller;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use App\Domains\Vehicle\Model\Vehicle as VehicleModel;

class Create extends ControllerAbstract
{
    /**
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function __invoke(): Response|RedirectResponse
    {
        if ($response = $this->actionPost('create')) {
            return $response;
        }

        $this->requestMergeWithRow();

        $this->meta('title', __('device-create.meta-title'));

        return $this->page('device.create', [
            'vehicles' => VehicleModel::query()->list()->get(),
        ]);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function create(): RedirectResponse
    {
        $this->row = $this->action()->create();

        $this->sessionMessage('success', __('device-create.success'));

        return redirect()->route('device.update', $this->row->id);
    }
}
