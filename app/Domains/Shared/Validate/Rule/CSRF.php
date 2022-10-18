<?php declare(strict_types=1);

namespace App\Domains\Shared\Validate\Rule;

use Throwable;
use Illuminate\Contracts\Validation\Rule as RuleContract;

class CSRF implements RuleContract
{
    /**
     * @param string $attribute
     * @param mixed $value
     *
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        try {
            return $value === csrf_token();
        } catch (Throwable $e) {
            return false;
        }
    }

    /**
     * @return string
     */
    public function message()
    {
        return __('validation.csrf');
    }
}
