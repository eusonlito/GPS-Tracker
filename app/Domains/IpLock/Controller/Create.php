<?php declare(strict_types=1);

namespace App\Domains\IpLock\Controller;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

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

        $this->meta('title', __('ip-lock-create.meta-title'));

        return $this->page('ip-lock.create');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function create(): RedirectResponse
    {
        $this->row = $this->action()->create();

        $this->sessionMessage('success', __('ip-lock-create.success'));

        return redirect()->route('ip-lock.update', $this->row->id);
    }
}
