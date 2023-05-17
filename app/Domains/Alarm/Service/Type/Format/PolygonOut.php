<?php declare(strict_types=1);

namespace App\Domains\Alarm\Service\Type\Format;

class PolygonOut extends Polygon
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
}
