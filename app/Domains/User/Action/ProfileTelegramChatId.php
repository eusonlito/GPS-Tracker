<?php declare(strict_types=1);

namespace App\Domains\User\Action;

use App\Domains\User\Model\User as Model;
use App\Services\Telegram\Client as TelegramClient;

class ProfileTelegramChatId extends ActionAbstract
{
    /**
     * @return \App\Domains\User\Model\User
     */
    public function handle(): Model
    {
        if ($this->isValid()) {
            return $this->row;
        }

        $this->data();
        $this->save();

        return $this->row;
    }

    /**
     * @return bool
     */
    protected function isValid(): bool
    {
        return ($this->row->telegram['username'] ?? false)
            && ($this->row->telegram['chat_id'] ?? false);
    }

    /**
     * @return void
     */
    protected function data(): void
    {
        $this->dataChatId();
    }

    /**
     * @return void
     */
    protected function dataChatId(): void
    {
        $this->data['telegram']['chat_id'] = TelegramClient::new()->chatId($this->row->telegram['username']);
    }

    /**
     * @return void
     */
    protected function save(): void
    {
        $this->row->telegram = $this->data['telegram'] + (array)$this->row->telegram;
        $this->row->save();
    }
}
