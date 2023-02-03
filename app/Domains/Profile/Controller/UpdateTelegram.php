<?php declare(strict_types=1);

namespace App\Domains\Profile\Controller;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

class UpdateTelegram extends ControllerAbstract
{
    /**
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function __invoke(): Response|RedirectResponse
    {
        $telegram = $this->telegram();

        if ($telegram->enabled() !== true) {
            return redirect()->back();
        }

        $this->load();

        if ($response = $this->actions()) {
            return $response;
        }

        $this->requestMergeWithRow();

        $this->meta('title', __('profile-update-telegram.meta-title'));

        return $this->page('profile.update-telegram', [
            'telegram_username' => $this->row->telegram['username'] ?? false,
            'telegram_chat_id' => $this->row->telegram['chat_id'] ?? false,
            'telegram_bot' => $telegram->config('bot'),
            'telegram_bot_link' => $telegram->botLink(),
        ]);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|false|null
     */
    protected function actions(): RedirectResponse|false|null
    {
        return $this->actionPost('updateTelegramChatId')
            ?: $this->actionPost('updateTelegram');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function updateTelegramChatId(): RedirectResponse
    {
        $this->action()->updateTelegramChatId();

        $this->sessionMessage('success', __('profile-update-telegram.success'));

        return redirect()->back();
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function updateTelegram(): RedirectResponse
    {
        $this->action()->updateTelegram();

        $this->sessionMessage('success', __('profile-update-telegram.success'));

        return redirect()->back();
    }
}
