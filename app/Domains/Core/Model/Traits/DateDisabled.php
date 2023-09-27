<?php declare(strict_types=1);

namespace App\Domains\Core\Model\Traits;

trait DateDisabled
{
    /**
     * @return array
     */
    public function getDates(): array
    {
        return [];
    }

    /**
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter
     *
     * @param string $key
     *
     * @return bool
     */
    protected function isDateAttribute($key): bool
    {
        return false;
    }
}
