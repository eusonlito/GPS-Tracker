<?php declare(strict_types=1);

namespace App\Services\Helper\Traits;

trait Custom
{
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
