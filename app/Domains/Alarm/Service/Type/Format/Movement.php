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
     * @return array
     */
    public function config(): array
    {
        return [];
    }

    /**
     * @return void
     */
    public function validate(): void
    {
    }

    /**
     * @param \App\Domains\Position\Model\Position $position
     *
     * @return ?bool
     */
    public function state(PositionModel $position): ?bool
    {
        return $position->speed > 0;
    }
}
