<?php declare(strict_types=1);

namespace App\Domains\User\Controller;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use App\Domains\Language\Model\Language as LanguageModel;
use App\Services\Telegram\Client as TelegramClient;

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
            'languages' => LanguageModel::query()->list()->get(),
            'telegram' => TelegramClient::new()->enabled(),
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
