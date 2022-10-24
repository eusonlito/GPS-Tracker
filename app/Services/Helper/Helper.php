<?php declare(strict_types=1);

namespace App\Services\Helper;

use App\Services\Helper\Traits\Arrays as ArraysTrait;
use App\Services\Helper\Traits\Custom as CustomTrait;
use App\Services\Helper\Traits\Date as DateTrait;
use App\Services\Helper\Traits\Exception as ExceptionTrait;
use App\Services\Helper\Traits\File as FileTrait;
use App\Services\Helper\Traits\Misc as MiscTrait;
use App\Services\Helper\Traits\Number as NumberTrait;

class Helper
{
    use ArraysTrait;
    use CustomTrait;
    use DateTrait;
    use ExceptionTrait;
    use FileTrait;
    use MiscTrait;
    use NumberTrait;
}
