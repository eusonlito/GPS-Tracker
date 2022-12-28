<?php declare(strict_types=1);

namespace App\Domains\Shared\Model\Traits;

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
    protected function isDateAttribute($key)
    {
        return false;
    }

    /**
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter
     *
     * @param string $key
     *
     * @return bool
     */
    protected function isDateCastable($key)
    {
        return false;
    }
}
