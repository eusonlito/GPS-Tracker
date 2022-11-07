<?php declare(strict_types=1);

namespace App\Domains\Device\Controller;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

class UpdateMessage extends ControllerAbstract
{
    /**
     * @param int $id
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function __invoke(int $id): Response|RedirectResponse
    {
        $this->row($id);

        if ($response = $this->actionPost('updateMessageCreate')) {
            return $response;
        }

        $this->meta('title', $this->row->name);

        return $this->page('device.update-message', [
            'row' => $this->row,
            'messages' => $this->row->messages()->list()->get(),
        ]);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function updateMessageCreate(): RedirectResponse
    {
        $this->action()->updateMessageCreate();

        $this->sessionMessage('success', __('device-update-message.create-success'));

        return redirect()->route('device.update.message', $this->row->id);
    }
}
