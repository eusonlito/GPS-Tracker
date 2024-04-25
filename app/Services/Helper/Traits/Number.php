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
     * @param string $symbol = '€'
     *
     * @return ?string
     */
    public function money(?float $value, int $decimals = 2, string $symbol = '€'): ?string
    {
        return $this->number($value, $decimals).' '.$symbol;
    }

    /**
     * @param int $bytes
     * @param int $decimals = 2
     *
     * @return string
     */
    public function sizeHuman(int $bytes, int $decimals = 2): string
    {
        $e = floor(log($bytes, 1024));
        $pow = pow(1024, $e);

        if ($pow === 0.0) {
            return '0 B';
        }

        $size = round($bytes / $pow, $decimals);
        $unit = ['B', 'KB', 'MB', 'GB', 'TB', 'PB'][$e];

        return $this->number($size, $decimals).' '.$unit;
    }
}
