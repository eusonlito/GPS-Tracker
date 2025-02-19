<?php declare(strict_types=1);

namespace App\Domains\Alarm\Service\Type\Format;

class Vibration extends FormatAbstract
{
    /**
     * @return string
     */
    public function code(): string
    {
        return 'vibration';
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return __('alarm-type-vibration.title');
    }

    /**
     * @return string
     */
    public function message(): string
    {
        return __('alarm-type-vibration.message');
    }

    /**
     * @return void
     */
    public function validate(): void
    {
    }

    /**
     * @return array
     */
    public function config(): array
    {
        return [];
    }
}
