<?php declare(strict_types=1);

namespace App\Domains\User\Controller;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

class Profile extends ControllerAbstract
{
    /**
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function __invoke(): Response|RedirectResponse
    {
        $this->rowAuth();

        if ($response = $this->actionPost('profile')) {
            return $response;
        }

        $this->requestMergeWithRow();

        $this->meta('title', __('user-profile.meta-title'));

        return $this->page('user.profile', [
            'row' => $this->row,
        ]);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function profile(): RedirectResponse
    {
        $this->action()->profile();

        $this->sessionMessage('success', __('user-profile.success'));

        return redirect()->route('user.profile');
    }
}
