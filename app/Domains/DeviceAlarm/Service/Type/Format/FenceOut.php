<?php declare(strict_types=1);

namespace App\Domains\DeviceAlarm\Service\Type\Format;

use App\Domains\Position\Model\Position as PositionModel;

class FenceOut extends FormatAbstract
{
    /**
     * @return string
     */
    public function code(): string
    {
        return 'fence-out';
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return __('device-alarm-type-fence-out.title');
    }

    /**
     * @return string
     */
    public function message(): string
    {
        return __('device-alarm-type-fence-out.message');
    }

    /**
     * @return void
     */
    public function validate(): void
    {
        $config = $this->config();

        if (empty($config['latitude'])) {
            $this->validateException(__('device-alarm-type-fence-out.error.latitude'));
        }

        if (empty($config['longitude'])) {
            $this->validateException(__('device-alarm-type-fence-out.error.longitude'));
        }

        if (empty($config['radius'])) {
            $this->validateException(__('device-alarm-type-fence-out.error.radius'));
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
            'radius' => floatval($this->config['radius'] ?? 0),
        ];
    }

    /**
     * @param \App\Domains\Position\Model\Position $position
     *
     * @return bool
     */
    public function checkPosition(PositionModel $position): bool
    {
        return $this->checkPositionDistance($position) >= $this->config()['radius'];
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
