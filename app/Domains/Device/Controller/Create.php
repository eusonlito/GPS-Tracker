<?php declare(strict_types=1);

namespace App\Domains\Device\Controller;

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

        $this->requestMergeWithRow(data: ['timezone' => 'Europe/Madrid']);

        $this->meta('title', __('device-create.meta-title'));

        return $this->page('device.create', [
            'timezones' => TimezoneModel::query()->select('id', 'zone')->list()->get(),
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
