<?php declare(strict_types=1);

namespace App\Domains\Profile\Controller;

use App\Domains\CoreApp\Controller\ControllerWebAbstract;
use App\Domains\User\Model\User as Model;
use App\Services\Telegram\Client as TelegramClient;

abstract class ControllerAbstract extends ControllerWebAbstract
{
    /**
     * @var ?\App\Domains\User\Model\User
     */
    protected ?Model $row;

    /**
     * @var \App\Services\Telegram\Client
     */
    protected TelegramClient $telegram;

    /**
     * @return void
     */
    protected function row(): void
    {
        $this->row = $this->auth;
    }

    /**
     * @return \App\Services\Telegram\Client
     */
    protected function telegram(): TelegramClient
    {
        return $this->telegram ??= TelegramClient::new();
    }

    /**
     * @return void
     */
    protected function load(): void
    {
        $this->row();
        $this->loadView();
    }

    /**
     * @return void
     */
    protected function loadView(): void
    {
        view()->share([
            'row' => $this->row,
            'telegram' => $this->telegram()->enabled(),
        ]);
    }
}
