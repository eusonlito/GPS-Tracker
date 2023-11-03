<?php declare(strict_types=1);

namespace App\Services\Telegram;

use stdClass;
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
        if ($this->enabled() === false) {
            return null;
        }

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
        return $this->request('GET', '/getUpdates')->result ?? [];
    }

    /**
     * @param int $chat_id
     * @param string $text
     *
     * @return ?\stdClass
     */
    public function message(int $chat_id, string $text): ?stdClass
    {
        if ($this->enabled() === false) {
            return null;
        }

        return $this->request('POST', '/sendMessage', [
            'chat_id' => $chat_id,
            'text' => $text,
            'parse_mode' => 'html',
        ]);
    }

    /**
     * @param string $method
     * @param string $path
     * @param array $body = []
     *
     * @return array|\stdClass|null
     */
    protected function request(string $method, string $path, array $body = []): array|stdClass|null
    {
        return Curl::new()
            ->setMethod($method)
            ->setUrl($this->requestUrl($path))
            ->setBody($body)
            ->setLog(true)
            ->setJson(true)
            ->send()
            ->getBody();
    }

    /**
     * @param string $path
     *
     * @return string
     */
    protected function requestUrl(string $path): string
    {
        return 'https://api.telegram.org/bot'.$this->config('token').$path;
    }
}
