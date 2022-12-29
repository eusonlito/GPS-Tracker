<?php declare(strict_types=1);

namespace App\Domains\Refuel\Controller;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use App\Domains\Refuel\Model\Refuel as Model;
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

        $this->requestMerge();

        $this->meta('title', __('refuel-create.meta-title'));

        return $this->page('refuel.create', [
            'vehicles' => VehicleModel::query()->byUserId($this->auth->id)->list()->get(),
        ]);
    }

    /**
     * @return void
     */
    protected function requestMerge(): void
    {
        $this->requestMergeWithRow(row: $this->previous());
    }

    /**
     * @return \App\Domains\Refuel\Model\Refuel
     */
    protected function previous(): Model
    {
        return Model::query()
            ->selectOnly('distance_total', 'price')
            ->byUserId($this->auth->id)
            ->orderByLast()
            ->firstOrNew();
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function create(): RedirectResponse
    {
        $this->row = $this->action()->create();

        $this->sessionMessage('success', __('refuel-create.success'));

        return redirect()->route('refuel.update', $this->row->id);
    }
}
