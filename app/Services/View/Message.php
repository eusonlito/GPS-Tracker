<?php declare(strict_types=1);

namespace App\Services\View;

use Throwable;
use Illuminate\Http\Request;
use Illuminate\Session\Store;
use Illuminate\Support\MessageBag;

class Message
{
    /**
     * @const string
     */
    protected const BAG = 'default';

    /**
     * @const string
     */
    protected const KEY = 'default';

    /**
     * @var self
     */
    protected static self $self;

    /**
     * @var array
     */
    protected array $current = [];

    /**
     * @var \Illuminate\Http\Request
     */
    protected Request $request;

    /**
     * @var \Illuminate\Session\Store
     */
    protected Store $session;

    /**
     * @return self
     */
    public static function instance(): self
    {
        return static::$self ??= new self();
    }

    /**
     * @return self
     */
    public static function reset(): self
    {
        return static::$self = new self();
    }

    /**
     * @return self
     */
    private function __construct()
    {
    }

    /**
     * @param string $message
     * @param string $bag = ''
     * @param string $key = ''
     *
     * @return void
     */
    public function success(string $message, string $bag = '', string $key = ''): void
    {
        $this->setMessage(__FUNCTION__, $bag, $key, $message);
    }

    /**
     * @param string $message
     * @param string $bag = ''
     * @param string $key = ''
     *
     * @return void
     */
    public function error(string $message, string $bag = '', string $key = ''): void
    {
        $this->setMessage(__FUNCTION__, $bag, $key, $message);
    }

    /**
     * @param \Throwable $e
     * @param string $bag = ''
     * @param string $key = ''
     *
     * @return void
     */
    public function throw(Throwable $e, string $bag = '', string $key = ''): void
    {
        $this->error($e->getMessage(), $bag, $key);

        throw $e;
    }

    /**
     * @param string $status
     * @param string $key
     *
     * @return \Illuminate\Support\MessageBag
     */
    public function get(string $status, string $key): MessageBag
    {
        $messages = $this->viewShareGet();

        if (empty($messages[$status])) {
            $messages[$status] = new Bag();
        }

        $this->sessionMessageDel($status, $key);

        return $messages[$status]->getBag($key);
    }

    /**
     * @param string $status
     *
     * @return array
     */
    public function getStatus(string $status): array
    {
        $messages = $this->viewShareGet();

        if (empty($messages[$status])) {
            return [];
        }

        $this->sessionMessageDelStatus($status);

        return $messages[$status]->getBags();
    }

    /**
     * @return array
     */
    public function getAll(): array
    {
        $messages = $this->viewShareGet();

        $this->sessionMessageDelAll();

        return $messages;
    }

    /**
     * @param array $messages
     *
     * @return void
     */
    public function set(array $messages): void
    {
        $this->sessionFlash($messages);
        $this->viewShareSet(array_map(fn ($value) => $this->setBag($value), $messages));
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return self
     */
    public function request(Request $request): self
    {
        $this->request = $request;

        return $this;
    }

    /**
     * @param \Illuminate\Session\Store $session
     *
     * @return self
     */
    public function session(Store $session): self
    {
        $this->session = $session;
        $this->set($this->session->get('messages', []));

        return $this;
    }

    /**
     * @param ?array $bags
     *
     * @return \App\Services\View\Bag
     */
    protected function setBag(?array $bags): Bag
    {
        $bag = new Bag();

        if (empty($bags)) {
            return $bag;
        }

        foreach ($bags as $key => $messages) {
            $bag->put($this->bagName($key), new MessageBag($messages));
        }

        return $bag;
    }

    /**
     * @param string $status
     * @param \App\Services\View\Bag $bag
     *
     * @return void
     */
    protected function share(string $status, Bag $bag): void
    {
        $this->viewShareSet([$status => $bag] + $this->viewShareGet());
    }

    /**
     * @param string $status
     * @param \Illuminate\Support\MessageBag $messageBag
     * @param string $bag = ''
     *
     * @return void
     */
    public function setMessageBag(string $status, MessageBag $messageBag, string $bag = ''): void
    {
        $this->share($status, $this->bag($bag, $messageBag));
    }

    /**
     * @param string $status
     * @param string $bag
     * @param string $key
     * @param string $message
     *
     * @return void
     */
    protected function setMessage(string $status, string $bag, string $key, string $message): void
    {
        if (isset($this->current[$status])) {
            return;
        }

        $this->setMessageBag($status, $this->messageBag($key, $message), $bag);
        $this->sessionMessageSet($status, $bag, $key, $message);

        $this->current[$status] = true;
    }

    /**
     * @param string $bag
     * @param \Illuminate\Support\MessageBag $messageBag
     *
     * @return \App\Services\View\Bag
     */
    protected function bag(string $bag, MessageBag $messageBag): Bag
    {
        return (new Bag())->put($this->bagName($bag), $messageBag);
    }

    /**
     * @param string $key
     * @param string $message
     *
     * @return \Illuminate\Support\MessageBag
     */
    protected function messageBag(string $key, string $message): MessageBag
    {
        return new MessageBag([$this->keyName($key) => $message]);
    }

    /**
     * @param string $status
     * @param string $bag
     * @param string $key
     * @param string $message
     *
     * @return void
     */
    protected function sessionMessageSet(string $status, string $bag, string $key, string $message): void
    {
        if ($this->sessionAvailable() === false) {
            return;
        }

        $messages = $this->session->get('messages', []);
        $messages[$status][$this->bagName($bag)][$this->keyName($key)] = $message;

        $this->sessionFlash($messages);
    }

    /**
     * @param string $status
     * @param string $bag
     *
     * @return void
     */
    protected function sessionMessageDel(string $status, string $bag): void
    {
        if ($this->sessionAvailable() === false) {
            return;
        }

        $messages = $this->session->get('messages', []);

        unset($messages[$status][$bag]);

        $this->sessionFlash($messages);
    }

    /**
     * @param string $status
     *
     * @return void
     */
    protected function sessionMessageDelStatus(string $status): void
    {
        if ($this->sessionAvailable() === false) {
            return;
        }

        $messages = $this->session->get('messages', []);

        unset($messages[$status]);

        $this->sessionFlash($messages);
    }

    /**
     * @return void
     */
    protected function sessionMessageDelAll(): void
    {
        if ($this->sessionAvailable() === false) {
            return;
        }

        $this->sessionFlash([]);
    }

    /**
     * @param array $messages
     *
     * @return void
     */
    protected function sessionFlash(array $messages): void
    {
        if ($this->sessionAvailable()) {
            $this->session->flash('messages', $messages);
        }
    }

    /**
     * @return array
     */
    protected function viewShareGet(): array
    {
        return view()->getShared()['messages'] ?? [];
    }

    /**
     * @param array $messages
     *
     * @return void
     */
    protected function viewShareSet(array $messages): void
    {
        view()->share(['messages' => $messages]);
    }

    /**
     * @return bool
     */
    protected function sessionAvailable(): bool
    {
        if (empty($this->session)) {
            return false;
        }

        return empty($this->request) || ($this->request->wantsJson() === false);
    }

    /**
     * @param string $name
     *
     * @return string
     */
    protected function bagName(string $name): string
    {
        return $name ?: static::BAG;
    }

    /**
     * @param string $name
     *
     * @return string
     */
    protected function keyName(string $name): string
    {
        return $name ?: static::KEY;
    }
}
