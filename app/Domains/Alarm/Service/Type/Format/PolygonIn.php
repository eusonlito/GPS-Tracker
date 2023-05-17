<?php declare(strict_types=1);

namespace App\Domains\Alarm\Service\Type\Format;

use App\Domains\Position\Model\Position as PositionModel;

class PolygonIn extends Polygon
{
    /**
     * @return string
     */
    public function code(): string
    {
        return 'polygon-in';
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return __('alarm-type-polygon-in.title');
    }

    /**
     * @return string
     */
    public function message(): string
    {
        return __('alarm-type-polygon-in.message');
    }
}
