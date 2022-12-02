<?php declare(strict_types=1);

namespace App\Domains\Server\Controller;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use App\Domains\Server\Model\Server as Model;
use App\Services\Server\Process as ServerProcess;

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

        return $this->page('server.status', [
            'list' => Model::query()->list()->get(),
            'process' => ServerProcess::new()->list(),
        ]);
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
        $this->action()->startPorts();

        $this->sessionMessage('success', __('server-status.start-success'));

        return redirect()->back();
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function stopPorts(): RedirectResponse
    {
        $this->action()->stopPorts();

        $this->sessionMessage('success', __('server-status.stop-success'));

        return redirect()->back();
    }
}
