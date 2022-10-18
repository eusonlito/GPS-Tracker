<?php declare(strict_types=1);

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class Message extends Component
{
    /**
     * @var string
     */
    public string $message = '';

    /**
     * @var string
     */
    public string $type;

    /**
     * @var string
     */
    public string $class;

    /**
     * @param string $type
     * @param string $bag = ''
     * @param string $message = ''
     *
     * @return self
     */
    public function __construct(string $type, string $bag = '', string $message = '')
    {
        $this->type($type);
        $this->class();
        $this->message($bag, $message);
    }

    /**
     * @param string $type
     *
     * @return void
     */
    protected function type(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return void
     */
    protected function class(): void
    {
        $this->class = 'alert-dismissible show flex items-center mb-2 mt-2 alert';
        $this->class .= ($this->type === 'error') ? ' alert-danger' : ' alert-success';
    }

    /**
     * @param string $bag
     * @param string $message
     *
     * @return void
     */
    protected function message(string $bag, string $message): void
    {
        if ($message) {
            $this->message = $message;
        } elseif ($bag) {
            $this->message = $this->messageBag($bag);
        } else {
            $this->message = $this->messageType();
        }
    }

    /**
     * @param string $bag
     *
     * @return string
     */
    protected function messageBag(string $bag): string
    {
        return service()->message()->get($this->type, $bag)->first();
    }

    /**
     * @return string
     */
    protected function messageType(): string
    {
        if (empty($messages = service()->message()->getStatus($this->type))) {
            return '';
        }

        return reset($messages)->first();
    }

    /**
     * @return ?\Illuminate\View\View
     */
    public function render(): ?View
    {
        if (empty($this->message)) {
            return null;
        }

        return view('components.message');
    }
}
