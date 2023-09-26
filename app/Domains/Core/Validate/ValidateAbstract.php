<?php declare(strict_types=1);

namespace App\Domains\Core\Validate;

use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use App\Services\Validator\ValidatorAbstract;

abstract class ValidateAbstract extends ValidatorAbstract
{
    /**
     * @param ?\Illuminate\Http\Request $request
     * @param array $data
     *
     * @return self
     */
    final public function __construct(protected ?Request $request, protected array $data)
    {
    }

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
