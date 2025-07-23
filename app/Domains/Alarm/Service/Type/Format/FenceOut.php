<?php declare(strict_types=1);

namespace App\Domains\Alarm\Service\Type\Format;

class FenceOut extends FenceAbstract
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
        return __('alarm-type-fence-out.title');
    }

    /**
     * @return string
     */
    public function message(): string
    {
        return __('alarm-type-fence-out.message');
    }

    /**
     * @param float $radius
     * @param float $distance
     *
     * @return bool
     */
    protected function stateValue(float $radius, float $distance): bool
    {
        return $distance > $radius;
    }
}
