<?php declare(strict_types=1);

namespace App\Domains\DeviceAlarm\Service\Type\Format;

use App\Domains\Position\Model\Position as PositionModel;

class FenceIn extends FormatAbstract
{
    /**
     * @return string
     */
    public function code(): string
    {
        return 'fence-in';
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return __('device-alarm-type-fence-in.title');
    }

    /**
     * @return string
     */
    public function message(): string
    {
        return __('device-alarm-type-fence-in.message');
    }

    /**
     * @return void
     */
    public function validate(): void
    {
        $config = $this->config();

        if (empty($config['latitude'])) {
            $this->validateException(__('device-alarm-type-fence-in.error.latitude'));
        }

        if (empty($config['longitude'])) {
            $this->validateException(__('device-alarm-type-fence-in.error.longitude'));
        }

        if (empty($config['radius'])) {
            $this->validateException(__('device-alarm-type-fence-in.error.radius'));
        }
    }

    /**
     * @return array
     */
    public function config(): array
    {
        return [
            'latitude' => floatval($this->config['latitude'] ?? 0),
            'longitude' => floatval($this->config['longitude'] ?? 0),
            'radius' => intval($this->config['radius'] ?? 0),
        ];
    }

    /**
     * @param \App\Domains\Position\Model\Position $position
     *
     * @return bool
     */
    public function checkPosition(PositionModel $position): bool
    {
        return $this->checkPositionDistance($position) <= $this->config()['radius'];
    }

    /**
     * @param \App\Domains\Position\Model\Position $position
     *
     * @return float
     */
    public function checkPositionDistance(PositionModel $position): float
    {
        return helper()->coordinatesDistance(
            $position->latitude,
            $position->longitude,
            $this->config()['latitude'],
            $this->config()['longitude'],
        ) / 1000;
    }
}
