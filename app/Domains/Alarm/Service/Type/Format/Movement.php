<?php declare(strict_types=1);

namespace App\Domains\Alarm\Service\Type\Format;

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

    /**
     * @param \App\Domains\Position\Model\Position $position
     *
     * @return bool
     */
    public function checkPosition(PositionModel $position): bool
    {
        return (bool)$position->speed;
    }
}
