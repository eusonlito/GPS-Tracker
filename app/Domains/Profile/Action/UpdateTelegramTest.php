<?php declare(strict_types=1);

namespace App\Domains\Profile\Action;

use App\Domains\User\Model\User as Model;
use App\Services\Telegram\Client as TelegramClient;

class UpdateTelegramTest extends ActionAbstract
{
    /**
     * @var \App\Services\Telegram\Client
     */
    protected TelegramClient $client;

    /**
     * @return \App\Domains\User\Model\User
     */
    public function handle(): Model
    {
        $this->client();
        $this->check();
        $this->send();

        return $this->row;
    }

    /**
     * @return void
     */
    protected function client(): void
    {
        $this->client = new TelegramClient();
    }

    /**
     * @return void
     */
    protected function check(): void
    {
        $this->checkUsername();
    }

    /**
     * @return void
     */
    protected function checkUsername(): void
    {
        if (empty($this->row->telegram['username'])) {
            $this->exceptionValidator(__('profile-update-telegram-test.error.username'));
        }

        if (empty($this->row->telegram['chat_id'])) {
            $this->exceptionValidator(__('profile-update-telegram-test.error.chat_id'));
        }

        if ($this->client->enabled() === false) {
            $this->exceptionValidator(__('profile-update-telegram-test.error.enabled'));
        }
    }

    /**
     * @return void
     */
    protected function send(): void
    {
        $this->client->message($this->row->telegram['chat_id'], __('profile-update-telegram-test.message'));
    }
}
