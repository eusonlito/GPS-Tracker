<?php declare(strict_types=1);

namespace App\Domains\DeviceAlarm\Service\Type\Format;

use App\Domains\Position\Model\Position as PositionModel;

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
        return __('device-alarm-type-movement.title');
    }

    /**
     * @return string
     */
    public function message(): string
    {
        return __('device-alarm-type-movement.message');
    }

    /**
     * @return array
     */
    public function config(): array
    {
        return [];
    }

    /**
     * @param \App\Domains\Position\Model\Position $position
     *
     * @return bool
     */
    public function checkPosition(PositionModel $position): bool
    {
        return true;
    }
}
