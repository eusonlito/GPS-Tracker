<?php declare(strict_types=1);

namespace App\Domains\Alarm\Controller;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use App\Domains\Alarm\Service\Controller\Create as ControllerService;

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

        $this->meta('title', __('alarm-create.meta-title'));

        return $this->page('alarm.create', $this->data());
    }

    /**
     * @return array
     */
    protected function data(): array
    {
        return ControllerService::new($this->request, $this->auth)->data();
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function create(): RedirectResponse
    {
        $this->row = $this->action()->create();

        $this->sessionMessage('success', __('alarm-create.success'));

        return redirect()->route('alarm.update', $this->row->id);
    }
}
