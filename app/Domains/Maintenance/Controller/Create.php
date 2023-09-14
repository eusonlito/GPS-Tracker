<?php declare(strict_types=1);

namespace App\Domains\Maintenance\Controller;

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

        $this->meta('title', __('maintenance-create.meta-title'));

        return $this->page('maintenance.create', [
            'vehicles' => VehicleModel::query()->byUserId($this->auth->id)->list()->get(),
            'files' => collect(),
        ]);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function create(): RedirectResponse
    {
        $this->row = $this->action()->create();

        $this->sessionMessage('success', __('maintenance-create.success'));

        return redirect()->route('maintenance.update', $this->row->id);
    }
}
