<?php declare(strict_types=1);

namespace App\Domains\DeviceAlarmNotification\Action;

use App\Domains\DeviceAlarmNotification\Model\DeviceAlarmNotification as Model;
use App\Services\Telegram\Client as TelegramClient;

class Notify extends ActionAbstract
{
    /**
     * @return \App\Domains\DeviceAlarmNotification\Model\DeviceAlarmNotification
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

        $telegram = $this->row->device->user->telegram;

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
        return __('device-alarm-notification-notify.telegram.message', [
            'alarm' => $this->row->alarm->name,
            'device' => $this->row->device->name,
            'message' => $this->row->typeFormat()->message(),
            'trip' => $this->row->trip->name,
            'trip_link' => route('trip.update.device-alarm-notification', $this->row->trip->id),
        ]);
    }
}
