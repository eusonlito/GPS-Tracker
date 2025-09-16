<?php declare(strict_types=1);

namespace App\Domains\Server\Controller;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use App\Domains\Server\Controller\Service\Status as ControllerService;

class Status extends ControllerAbstract
{
    /**
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function __invoke(): Response|RedirectResponse
    {
        if ($response = $this->actions()) {
            return $response;
        }

        $this->meta('title', __('server-status.meta-title'));

        return $this->page('server.status', $this->data());
    }

    /**
     * @return array
     */
    protected function data(): array
    {
        return ControllerService::new($this->request, $this->auth)->data();
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|false|null
     */
    protected function actions(): RedirectResponse|false|null
    {
        return $this->actionPost('startPorts')
            ?: $this->actionPost('stopPorts');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function startPorts(): RedirectResponse
    {
        if (config('demo.enabled')) {
            $this->exceptionValidator(__('demo.error.not-allowed'));
        }

        $this->action()->startPorts();

        $this->sessionMessage('success', __('server-status.start-success'));

        return redirect()->back();
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function stopPorts(): RedirectResponse
    {
        if (config('demo.enabled')) {
            $this->exceptionValidator(__('demo.error.not-allowed'));
        }

        $this->action()->stopPorts();

        $this->sessionMessage('success', __('server-status.stop-success'));

        return redirect()->back();
    }
}
