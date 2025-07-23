<?php declare(strict_types=1);

namespace App\Domains\Alarm\Service\Type\Format;

use App\Domains\Position\Model\Position as PositionModel;

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
     * @return array
     */
    public function config(): array
    {
        return [
            'speed' => intval($this->config['speed'] ?? 0),
        ];
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
     * @param \App\Domains\Position\Model\Position $position
     *
     * @return ?bool
     */
    public function state(PositionModel $position): ?bool
    {
        $speed = $this->config()['speed'];

        if ($speed === 0) {
            return null;
        }

        return $position->userSpeed() > $speed;
    }
}
