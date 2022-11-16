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
        if (empty($this->config['latitude']) || empty($this->config['longitude']) || empty($this->config['radius'])) {
            return false;
        }

        $meters = helper()->coordinatesDistance(
            $position->latitude,
            $position->longitude,
            $this->config['latitude'],
            $this->config['longitude'],
        );

        return ($meters / 1000) <= $this->config['radius'];
    }
}
