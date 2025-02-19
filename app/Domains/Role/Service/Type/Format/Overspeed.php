<?php declare(strict_types=1);

namespace App\Domains\Alarm\Service\Type\Format;

class Overspeed extends FormatAbstract
{
    /**
     * @return string
     */
    public function code(): string
    {
        return 'overspeed';
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return __('alarm-type-overspeed.title');
    }

    /**
     * @return string
     */
    public function message(): string
    {
        return __('alarm-type-overspeed.message');
    }

    /**
     * @return void
     */
    public function validate(): void
    {
        if ($this->config()['speed'] === 0) {
            $this->exceptionValidator(__('alarm-type-overspeed.error.speed'));
        }
    }

    /**
     * @return array
     */
    public function config(): array
    {
        return [
            'speed' => intval($this->config['speed'] ?? 0),
        ];
    }
}
