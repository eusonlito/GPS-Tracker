<?php declare(strict_types=1);

namespace App\Domains\Shared\Model\Traits;

trait MutatorDisabled
{
    /**
     * @param string $key
     *
     * @return bool
     */
    public function hasGetMutator($key)
    {
        return false;
    }

    /**
     * @param string $key
     *
     * @return bool
     */
    public function hasSetMutator($key)
    {
        return false;
    }
}
