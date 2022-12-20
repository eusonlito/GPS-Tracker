<?php declare(strict_types=1);

namespace App\Domains\AlarmNotification\Action;

use App\Domains\AlarmNotification\Model\AlarmNotification as Model;
use App\Services\Telegram\Client as TelegramClient;

class Notify extends ActionAbstract
{
    /**
     * @return \App\Domains\AlarmNotification\Model\AlarmNotification
     */
    public function handle(): Model
    {
        $this->telegram();

        return $this->row;
    }

    /**
     * @return void
     */
    protected function telegram(): void
    {
        if ($chatId = $this->telegramChatId()) {
            TelegramClient::new()->message($chatId, $this->telegramMessage());
        }
    }

    /**
     * @return ?int
     */
    protected function telegramChatId(): ?int
    {
        if (empty($this->row->telegram)) {
            return null;
        }

        if (TelegramClient::new()->enabled() === false) {
            return null;
        }

        $telegram = $this->row->vehicle->user->telegram;

        if (empty($telegram['username'])) {
            return null;
        }

        return $telegram['chat_id'] ?? null ?: null;
    }

    /**
     * @return string
     */
    protected function telegramMessage(): string
    {
        return __('alarm-notification-notify.telegram.message', [
            'alarm' => $this->row->alarm->name,
            'vehicle' => $this->row->vehicle->name,
            'message' => $this->row->typeFormat()->message(),
            'trip' => $this->row->trip->name,
            'trip_link' => route('trip.update.alarm-notification', $this->row->trip->id),
        ]);
    }
}
