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

    /**
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter
     *
     * @param string $key
     *
     * @return bool
     */
    public function hasAttributeMutator($key)
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
    public function hasAttributeGetMutator($key)
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
    public function hasAttributeSetMutator($key)
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

    /**
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter
     *
     * @param string $key
     *
     * @return bool
     */
    protected function isDateCastableWithCustomFormat($key)
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
    protected function isClassCastable($key)
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
    protected function isEnumCastable($key)
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
    protected function isClassDeviable($key)
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
    protected function isClassSerializable($key)
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
    public function hasAppended($attribute)
    {
        return false;
    }
}
