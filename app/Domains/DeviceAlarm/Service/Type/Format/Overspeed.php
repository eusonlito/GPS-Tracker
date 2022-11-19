<?php declare(strict_types=1);

namespace App\Domains\DeviceAlarm\Service\Type\Format;

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
        return __('device-alarm-type-overspeed.title');
    }

    /**
     * @return string
     */
    public function message(): string
    {
        return __('device-alarm-type-overspeed.message');
    }

    /**
     * @return void
     */
    public function validate(): void
    {
        if ($this->config()['speed'] === 0) {
            $this->validateException(__('device-alarm-type-overspeed.error.speed'));
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

    /**
     * @param \App\Domains\Position\Model\Position $position
     *
     * @return bool
     */
    public function checkPosition(PositionModel $position): bool
    {
        return $position->speed > $this->config()['speed'];
    }
}
