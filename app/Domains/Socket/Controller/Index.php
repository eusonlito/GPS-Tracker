<?php declare(strict_types=1);

namespace App\Domains\Socket\Controller;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use App\Services\Server\Process as ServerProcess;

class Index extends ControllerAbstract
{
    /**
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function __invoke(): Response|RedirectResponse
    {
        if ($response = $this->actions()) {
            return $response;
        }

        $this->meta('title', __('socket-index.meta-title'));

        return $this->page('socket.index', [
            'process' => ServerProcess::new()->list(),
            'servers' => config('servers'),
        ]);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|false|null
     */
    protected function actions(): RedirectResponse|false|null
    {
        return $this->actionPost('serverPorts')
            ?: $this->actionPost('killPorts');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function serverPorts(): RedirectResponse
    {
        $this->action()->serverPorts();

        $this->sessionMessage('success', __('socket-index.server-success'));

        return redirect()->back();
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function killPorts(): RedirectResponse
    {
        $this->action()->killPorts();

        $this->sessionMessage('success', __('socket-index.kill-success'));

        return redirect()->back();
    }
}
