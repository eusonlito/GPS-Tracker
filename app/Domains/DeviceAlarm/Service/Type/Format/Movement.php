<?php declare(strict_types=1);

namespace App\Domains\DeviceAlarm\Service\Type\Format;

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
        return __('device-alarm-type.movement');
    }

    /**
     * @return array
     */
    public function config(): array
    {
        return [];
    }
}
