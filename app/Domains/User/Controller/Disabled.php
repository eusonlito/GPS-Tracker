<?php declare(strict_types=1);

namespace App\Domains\User\Controller;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

class Disabled extends ControllerAbstract
{
    /**
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function __invoke(): Response|RedirectResponse
    {
        if ($this->auth->enabled) {
            return redirect()->route('dashboard.index');
        }

        $this->meta('title', __('user-disabled.meta-title'));

        return $this->page('user.disabled');
    }
}
