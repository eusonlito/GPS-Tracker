<?php declare(strict_types=1);

namespace App\Domains\User\Controller;

use Illuminate\Http\RedirectResponse;

class Logout extends ControllerAbstract
{
    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(): RedirectResponse
    {
        $this->action($this->auth)->logout();

        return redirect()->route('user.auth.credentials');
    }
}
