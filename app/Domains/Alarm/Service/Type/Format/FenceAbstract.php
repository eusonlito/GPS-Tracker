<?php declare(strict_types=1);

namespace App\Domains\Alarm\Service\Type\Format;

use App\Domains\Position\Model\Position as PositionModel;

abstract class FenceAbstract extends FormatAbstract
{
    /**
     * @param float $radius
     * @param float $distance
     *
     * @return bool
     */
    abstract protected function stateValue(float $radius, float $distance): bool;

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
     * @return void
     */
    public function validate(): void
    {
        $config = $this->config();

        if (empty($config['latitude'])) {
            $this->exceptionValidator(__('alarm-type-fence.error.latitude'));
        }

        if (empty($config['longitude'])) {
            $this->exceptionValidator(__('alarm-type-fence.error.longitude'));
        }

        if (empty($config['radius'])) {
            $this->exceptionValidator(__('alarm-type-fence.error.radius'));
        }
    }

    /**
     * @param \App\Domains\Position\Model\Position $position
     *
     * @return ?bool
     */
    public function state(PositionModel $position): ?bool
    {
        $config = $this->config();

        if (empty($config['latitude'])) {
            return null;
        }

        if (empty($config['longitude'])) {
            return null;
        }

        if (empty($config['radius'])) {
            return null;
        }

        $distance = helper()->coordinatesDistance(
            $config['latitude'],
            $config['longitude'],
            $position->latitude,
            $position->longitude,
        );

        return $this->stateValue($config['radius'] * 1000, $distance);
    }
}
