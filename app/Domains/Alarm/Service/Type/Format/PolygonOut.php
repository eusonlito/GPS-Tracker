<?php declare(strict_types=1);

namespace App\Domains\Alarm\Service\Type\Format;

class PolygonOut extends PolygonAbstract
{
    /**
     * @return string
     */
    public function code(): string
    {
        return 'polygon-out';
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return __('alarm-type-polygon-out.title');
    }

    /**
     * @return string
     */
    public function message(): string
    {
        return __('alarm-type-polygon-out.message');
    }

    /**
     * @param bool $inside
     *
     * @return bool
     */
    protected function stateValue(bool $inside): bool
    {
        return $inside === false;
    }
}
