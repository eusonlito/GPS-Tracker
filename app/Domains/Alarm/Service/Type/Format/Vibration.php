<?php declare(strict_types=1);

namespace App\Domains\Alarm\Service\Type\Format;

use App\Domains\Position\Model\Position as PositionModel;

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
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter
     *
     * @param \App\Domains\Position\Model\Position $position
     *
     * @return ?bool
     */
    public function state(PositionModel $position): ?bool
    {
        return true;
    }
}
