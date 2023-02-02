<?php declare(strict_types=1);

namespace App\Domains\User\Controller;

use App\Services\Telegram\Client as TelegramClient;

abstract class ProfileAbstract extends ControllerAbstract
{
    /**
     * @return void
     */
    protected function load(): void
    {
        $this->rowAuth();
        $this->loadView();
    }

    /**
     * @return void
     */
    protected function loadView(): void
    {
        view()->share([
            'row' => $this->row,
            'telegram' => TelegramClient::new()->enabled(),
        ]);
    }
}
