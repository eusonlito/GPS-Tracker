<?php declare(strict_types=1);

namespace App\Services\Telegram;

use App\Services\Http\Curl\Curl;

class Client
{
    /**
     * @var array
     */
    protected array $config;

    /**
     * @return self
     */
    public static function new(): self
    {
        return new static(...func_get_args());
    }

    /**
     * @return self
     */
    public function __construct()
    {
        $this->config = (array)config('telegram');
    }

    /**
     * @param string $key
     *
     * @return mixed
     */
    public function config(string $key): mixed
    {
        return $this->config[$key] ?? null;
    }

    /**
     * @return string
     */
    public function botLink(): string
    {
        return 'http://t.me/'.$this->config('bot');
    }

    /**
     * @return bool
     */
    public function enabled(): bool
    {
        return ($this->config('enabled') === true)
            && $this->config('bot')
            && $this->config('token');
    }

    /**
     * @param string $username
     *
     * @return ?int
     */
    public function chatId(string $username): ?int
    {
        foreach ($this->getUpdates() as $update) {
            if (($update->message->chat->type === 'private') && ($update->message->chat->username === $username)) {
                return $update->message->chat->id;
            }
        }

        return null;
    }

    /**
     * @return array
     */
    protected function getUpdates(): array
    {
        return Curl::new()
            ->setUrl('https://api.telegram.org/bot'.$this->config('token').'/getUpdates')
            ->setJson()
            ->send()
            ->getBody()
            ->result;
    }
}
