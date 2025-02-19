<?php declare(strict_types=1);

namespace App\Domains\Alarm\Service\Type\Format;

class Movement extends FormatAbstract
{
    /**
     * @return string
     */
    public function code(): string
    {
        return 'movement';
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return __('alarm-type-movement.title');
    }

    /**
     * @return string
     */
    public function message(): string
    {
        return __('alarm-type-movement.message');
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
