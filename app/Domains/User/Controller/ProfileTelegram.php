<?php declare(strict_types=1);

namespace App\Domains\User\Controller;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use App\Services\Telegram\Client as TelegramClient;

class ProfileTelegram extends ControllerAbstract
{
    /**
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function __invoke(): Response|RedirectResponse
    {
        $service = new TelegramClient();

        if ($service->enabled() !== true) {
            return redirect()->back();
        }

        $this->rowAuth();

        if ($response = $this->actions()) {
            return $response;
        }

        $this->requestMergeWithRow();

        $this->meta('title', __('user-profile-telegram.meta-title'));

        return $this->page('user.profile-telegram', [
            'row' => $this->row,
            'telegram' => true,
            'telegram_username' => $this->row->telegram['username'] ?? false,
            'telegram_chat_id' => $this->row->telegram['chat_id'] ?? false,
            'telegram_bot' => $service->config('bot'),
            'telegram_bot_link' => $service->botLink(),
        ]);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|false|null
     */
    protected function actions(): RedirectResponse|false|null
    {
        return $this->actionPost('profileTelegramChatId')
            ?: $this->actionPost('profileTelegram');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function profileTelegramChatId(): RedirectResponse
    {
        $this->action()->profileTelegramChatId();

        $this->sessionMessage('success', __('user-profile-telegram.success'));

        return redirect()->back();
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function profileTelegram(): RedirectResponse
    {
        $this->action()->profileTelegram();

        $this->sessionMessage('success', __('user-profile-telegram.success'));

        return redirect()->back();
    }
}
