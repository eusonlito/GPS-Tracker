<?php declare(strict_types=1);

namespace App\Domains\Shared\Model\Traits;

trait MutatorDisabled
{
    /**
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter
     *
     * @param string $key
     *
     * @return bool
     */
    public function hasGetMutator($key)
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
    public function hasSetMutator($key)
    {
        return false;
    }
}
