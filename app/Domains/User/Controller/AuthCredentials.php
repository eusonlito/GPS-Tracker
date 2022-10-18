<?php declare(strict_types=1);

namespace App\Domains\User\Controller;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use App\Services\Captcha\Captcha;

class AuthCredentials extends ControllerAbstract
{
    /**
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function __invoke(): Response|RedirectResponse
    {
        if ($response = $this->actionPost('authCredentials')) {
            return $response;
        }

        $this->meta('title', __('user-auth-credentials.meta-title'));

        return $this->page('user.auth-credentials', [
            'captcha' => Captcha::new()->requiredAuth(),
        ]);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function authCredentials(): RedirectResponse
    {
        $this->action()->authCredentials();

        return redirect()->route('dashboard.index');
    }
}
