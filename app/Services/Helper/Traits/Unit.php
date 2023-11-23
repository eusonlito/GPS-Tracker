<?php declare(strict_types=1);

namespace App\Services\Helper\Traits;

use UnexpectedValueException;

trait Unit
{
    /**
     * @param string $type
     * @param float $value
     * @param int $round = 2
     *
     * @return float
     */
    public function unit(string $type, float $value, int $round = 2): float
    {
        return match ($type) {
            'money' => $this->unitMoney($value, $round),
            'volume' => $this->unitVolume($value, $round),
            'distance' => $this->unitDistance($value, $round),
            'speed' => $this->unitSpeed($value, $round),
            default => $this->unitException($type),
        };
    }

    /**
     * @param string $type
     * @param float $value
     * @param int $round = 2
     *
     * @return string
     */
    public function unitHuman(string $type, float $value, int $round = 2): string
    {
        return match ($type) {
            'money' => $this->unitMoneyHuman($value, $round),
            'volume' => $this->unitVolumeHuman($value, $round),
            'distance' => $this->unitDistanceHuman($value, $round),
            'speed' => $this->unitSpeedHuman($value, $round),
            default => $this->unitException($type),
        };
    }

    /**
     * @param string $type
     * @param float $value
     * @param int $round = 2
     *
     * @return string
     */
    public function unitHumanRaw(string $type, float $value, int $round = 2): string
    {
        return match ($type) {
            'money' => $this->unitMoneyHumanRaw($value, $round),
            'volume' => $this->unitVolumeHumanRaw($value, $round),
            'distance' => $this->unitDistanceHumanRaw($value, $round),
            'speed' => $this->unitSpeedHumanRaw($value, $round),
            default => $this->unitException($type),
        };
    }

    /**
     * @param float $value
     * @param int $round = 2
     *
     * @return float
     */
    public function unitMoney(float $value, int $round = 2): float
    {
        return round($value, $round);
    }

    /**
     * @param float $value
     * @param int $round = 2
     *
     * @return string
     */
    public function unitMoneyHuman(float $value, int $round = 2): string
    {
        $value = $this->unitFormat($this->unitMoney($value, $round), $round);

        return match ($this->unitPreferences()['money']) {
            'euro' => $value.' €',
            'dollar' => '$'.$value,
            default => strval($value),
        };
    }

    /**
     * @param float $value
     * @param int $round = 2
     *
     * @return string
     */
    public function unitMoneyHumanRaw(float $value, int $round = 2): string
    {
        $value = $this->unitFormat($value, $round);

        return match ($this->unitPreferences()['money']) {
            'euro' => $value.' €',
            'dollar' => '$'.$value,
            default => strval($value),
        };
    }

    /**
     * @param float $value
     * @param int $round = 2
     *
     * @return float
     */
    public function unitVolume(float $value, int $round = 2): float
    {
        return round(match ($this->unitPreferences()['volume']) {
            'gallon' => $value * 0.264172,
            default => $value,
        }, $round);
    }

    /**
     * @param float $value
     * @param int $round = 2
     *
     * @return string
     */
    public function unitVolumeHuman(float $value, int $round = 2): string
    {
        $value = $this->unitFormat($this->unitVolume($value, $round), $round);

        return match ($this->unitPreferences()['volume']) {
            'liter' => $value.' L',
            'gallon' => $value.' gal',
            default => strval($value),
        };
    }

    /**
     * @param float $value
     * @param int $round = 2
     *
     * @return string
     */
    public function unitVolumeHumanRaw(float $value, int $round = 2): string
    {
        $value = $this->unitFormat($value, $round);

        return match ($this->unitPreferences()['volume']) {
            'liter' => $value.' L',
            'gallon' => $value.' gal',
            default => strval($value),
        };
    }

    /**
     * @param float $value
     * @param int $round = 2
     *
     * @return float
     */
    public function unitDistance(float $value, int $round = 2): float
    {
        return round(match ($this->unitPreferences()['distance']) {
            'mile' => $value * 0.621371,
            default => $value,
        } / 1000, $round);
    }

    /**
     * @param float $value
     * @param int $round = 2
     *
     * @return string
     */
    public function unitDistanceHuman(float $value, int $round = 2): string
    {
        $value = $this->unitFormat($this->unitDistance($value, $round), $round);

        return match ($this->unitPreferences()['distance']) {
            'kilometer' => $value.' km',
            'mile' => $value.' mi',
            default => strval($value),
        };
    }

    /**
     * @param float $value
     * @param int $round = 2
     *
     * @return string
     */
    public function unitDistanceHumanRaw(float $value, int $round = 2): string
    {
        $value = $this->unitFormat($value, $round);

        return match ($this->unitPreferences()['distance']) {
            'kilometer' => $value.' km',
            'mile' => $value.' mi',
            default => strval($value),
        };
    }

    /**
     * @param float $value
     * @param int $round = 2
     *
     * @return float
     */
    public function unitSpeed(float $value, int $round = 2): float
    {
        return round(match ($this->unitPreferences()['distance']) {
            'mile' => $value * 0.621371,
            default => $value,
        }, $round);
    }

    /**
     * @param float $value
     * @param int $round = 2
     *
     * @return string
     */
    public function unitSpeedHuman(float $value, int $round = 2): string
    {
        $value = $this->unitFormat($this->unitSpeed($value, $round), $round);

        return match ($this->unitPreferences()['distance']) {
            'kilometer' => $value.' km/h',
            'mile' => $value.' mi/h',
            default => strval($value),
        };
    }

    /**
     * @param float $value
     * @param int $round = 2
     *
     * @return string
     */
    public function unitSpeedHumanRaw(float $value, int $round = 2): string
    {
        $value = $this->unitFormat($value, $round);

        return match ($this->unitPreferences()['distance']) {
            'kilometer' => $value.' km/h',
            'mile' => $value.' mi/h',
            default => strval($value),
        };
    }

    /**
     * @param float $value
     * @param int $round = 2
     *
     * @return string
     */
    public function unitFormat(float $value, int $round = 2): string
    {
        $preferences = $this->unitPreferences();

        return number_format($value, $round, $preferences['decimal'], $preferences['thousand']);
    }

    /**
     * @return array
     */
    protected function unitPreferences(): array
    {
        return $this->cache[__FUNCTION__] ??= (app('user')->preferences['units'] ?? []) + [
            'money' => 'euro',
            'volume' => 'liter',
            'decimal' => ',',
            'distance' => 'kilometer',
            'thousand' => '.',
        ];
    }

    /**
     * @param string $type
     *
     * @return void
     */
    protected function unitException(string $type): void
    {
        throw new UnexpectedValueException(__('unit.error.invalid', ['unit' => $type]));
    }
}
