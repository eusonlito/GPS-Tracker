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
     * @return void
     */
    public function validate(): void
    {
        if ($this->config()['speed'] === 0) {
            $this->validateException(__('alarm-type-overspeed.error.speed'));
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
        return $this->speed($position) > $this->config()['speed'];
    }

    /**
     * @param \App\Domains\Position\Model\Position $position
     *
     * @return float
     */
    protected function speed(PositionModel $position): float
    {
        return match ($position->user->preferences['units']['distance'] ?? 'kilometer') {
            'mile' => $position->speed * 0.621371,
            default => $position->speed,
        };
    }
}
