<?php declare(strict_types=1);

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class Message extends Component
{
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
    public function __construct(
        readonly protected string $type,
        readonly protected string $bag = '',
        public string $message = ''
    ) {
        $this->class();
        $this->message();
    }

    /**
     * @return bool
     */
    public function shouldRender(): bool
    {
        return boolval($this->message);
    }

    /**
     * @return \Illuminate\View\View
     */
    public function render(): View
    {
        return view('components.message');
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
     * @return void
     */
    protected function message(): void
    {
        if ($this->message) {
            return;
        }

        $this->message = $this->bag
            ? $this->messageBag()
            : $this->messageType();
    }

    /**
     * @return string
     */
    protected function messageBag(): string
    {
        return service()->message()->get($this->type, $this->bag)->first();
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
}
