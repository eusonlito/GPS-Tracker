<?php declare(strict_types=1);

namespace App\Domains\Vehicle\Controller;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use App\Domains\Timezone\Model\Timezone as TimezoneModel;

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

        $this->requestMergeWithRow(data: $this->requestMergeWithRowData());

        $this->meta('title', __('vehicle-create.meta-title'));

        return $this->page('vehicle.create', [
            'timezones' => TimezoneModel::query()->list()->get(),
        ]);
    }

    /**
     * @return array
     */
    protected function requestMergeWithRowData(): array
    {
        return [
            'timezone_id' => TimezoneModel::query()->whereDefault()->value('id'),
        ];
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function create(): RedirectResponse
    {
        $this->row = $this->action()->create();

        $this->sessionMessage('success', __('vehicle-create.success'));

        return redirect()->route('vehicle.update', $this->row->id);
    }
}
