<?php declare(strict_types=1);

namespace App\Services\Logger;

class DeprecationsDaily extends DailyAbstract
{
    /**
     * @var bool
     */
    protected bool $includeStacktracesVendor = true;

    /**
     * @return string
     */
    protected function name(): string
    {
        return 'deprecations';
    }
}
