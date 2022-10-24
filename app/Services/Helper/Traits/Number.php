<?php declare(strict_types=1);

namespace App\Services\Helper\Traits;

trait Number
{
    /**
     * @param ?float $value
     * @param int $decimals = 2
     * @param ?string $default = '-'
     *
     * @return ?string
     */
    public function number(?float $value, int $decimals = 2, ?string $default = '-'): ?string
    {
        if ($value === null) {
            return $default;
        }

        return number_format($value, $decimals, ',', '.');
    }

    /**
     * @param ?float $value
     * @param int $decimals = 2
     *
     * @return ?string
     */
    public function money(?float $value, int $decimals = 2): ?string
    {
        return $this->number($value, $decimals).'€';
    }

    /**
     * @param int $bytes
     * @param int $decimals = 2
     *
     * @return string
     */
    public function sizeHuman(int $bytes, int $decimals = 2): string
    {
        if ($bytes === 0) {
            return '0B';
        }

        $e = floor(log($bytes, 1024));

        return round($bytes / pow(1024, $e), $decimals).['B', 'KB', 'MB', 'GB', 'TB', 'PB'][$e];
    }

    /**
     * @param int $meters
     * @param int $decimals = 2
     *
     * @return string
     */
    public function distanceHuman(int $meters, int $decimals = 2): string
    {
        if ($meters >= 1000) {
            $meters /= 1000;
            $units = 'km';
        } else {
            $decimals = 0;
            $units = 'm';
        }

        return $this->number($meters, $decimals).' '.$units;
    }
}
