<?php declare(strict_types=1);

namespace App\Domains\Monitor\Controller;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use App\Domains\Monitor\Service\Controller\Queue as ControllerService;

class Queue extends ControllerAbstract
{
    /**
     * @param string $name = ''
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function __invoke(string $name = ''): Response|RedirectResponse
    {
        if ($response = $this->actionPost('failedRetry')) {
            return $response;
        }

        $this->meta('title', __('monitor-queue.meta-title'));

        $data = $this->data($name);

        return $this->page('monitor.queue.'.$data['name'], $data);
    }

    /**
     * @param string $name
     *
     * @return array
     */
    protected function data(string $name): array
    {
        return ControllerService::new($this->request, $this->auth, $name)->data();
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function failedRetry(): RedirectResponse
    {
        $this->action()->queueFailedRetry();

        $this->sessionMessage('success', __('monitor-queue-failed.retry-success'));

        return redirect()->back();
    }
}
