<?php declare(strict_types=1);

namespace App\Domains\Shared\Validate;

use Illuminate\Support\MessageBag;
use App\Services\Validator\ValidatorAbstract;

abstract class ValidateAbstract extends ValidatorAbstract implements ValidateInterface
{
    /**
     * @param \Illuminate\Support\MessageBag $errors
     *
     * @return void
     */
    protected function notify(MessageBag $errors): void
    {
        $messages = $errors->messages();
        $key = key($messages);

        service()->message()->error($messages[$key][0], 'validate', $key);
    }
}
