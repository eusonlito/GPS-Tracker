<?php declare(strict_types=1);

namespace App\Domains\Core\Model\Traits;

trait MutatorDisabled
{
    /**
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter
     *
     * @param string $key
     *
     * @return bool
     */
    public function hasGetMutator($key): bool
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
    public function hasSetMutator($key): bool
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
    public function hasAttributeMutator($key): bool
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
    public function hasAttributeGetMutator($key): bool
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
    public function hasAttributeSetMutator($key): bool
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
    protected function isDateCastable($key): bool
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
    protected function isDateCastableWithCustomFormat($key): bool
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
    protected function isEnumCastable($key): bool
    {
        return false;
    }

    /**
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter
     *
     * @param string $attribute
     *
     * @return bool
     */
    public function hasAppended($attribute): bool
    {
        return false;
    }
}
