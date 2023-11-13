<?php declare(strict_types=1);

namespace App\Domains\Device\Controller;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use App\Domains\Device\Service\Controller\UpdateTransfer as ControllerService;

class UpdateTransfer extends ControllerAbstract
{
    /**
     * @param int $id
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function __invoke(int $id): Response|RedirectResponse
    {
        $this->row($id);

        if ($response = $this->actionPost('updateTransfer')) {
            return $response;
        }

        $this->meta('title', __('device-update-transfer.meta-title', ['title' => $this->row->name]));

        return $this->page('device.update-transfer', $this->data());
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
    protected function updateTransfer(): RedirectResponse
    {
        $this->action()->updateTransfer();

        $this->sessionMessage('success', __('device-update-transfer.success'));

        return redirect()->route('device.index');
    }
}
