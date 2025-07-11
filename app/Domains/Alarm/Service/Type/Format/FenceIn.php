<?php declare(strict_types=1);

namespace App\Domains\Alarm\Service\Type\Format;

class FenceIn extends FenceAbstract
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
        return __('alarm-type-fence-in.title');
    }

    /**
     * @return string
     */
    public function message(): string
    {
        return __('alarm-type-fence-in.message');
    }

    /**
     * @param float $radius
     * @param float $distance
     *
     * @return bool
     */
    protected function stateValue(float $radius, float $distance): bool
    {
        return $distance <= $radius;
    }
}
