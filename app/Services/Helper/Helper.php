<?php declare(strict_types=1);

namespace App\Services\Helper;

use App\Services\Helper\Traits\Arrays as ArraysTrait;
use App\Services\Helper\Traits\Date as DateTrait;
use App\Services\Helper\Traits\Exception as ExceptionTrait;
use App\Services\Helper\Traits\File as FileTrait;
use App\Services\Helper\Traits\Geo as GeoTrait;
use App\Services\Helper\Traits\Misc as MiscTrait;
use App\Services\Helper\Traits\Number as NumberTrait;
use App\Services\Helper\Traits\Unit as UnitTrait;

class Helper
{
    use ArraysTrait;
    use DateTrait;
    use ExceptionTrait;
    use FileTrait;
    use GeoTrait;
    use MiscTrait;
    use NumberTrait;
    use UnitTrait;

    /**
     * @var array
     */
    protected array $cache = [];
}
