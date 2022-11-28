<?php declare(strict_types=1);

namespace App\Services\Validator;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator as ValidatorFacade;
use Illuminate\Support\MessageBag;
use Illuminate\Validation\Validator as ValidatorService;

abstract class ValidatorAbstract
{
    /**
     * @return array
     */
    abstract public function rules(): array;

    /**
     * @return self
     */
    public static function new(): self
    {
        return new static(...func_get_args());
    }

    /**
     * @param ?\Illuminate\Http\Request $request
     * @param array $data
     *
     * @return self
     */
    public function __construct(protected ?Request $request, protected array $data)
    {
    }

    /**
     * @return array
     */
    public function data(): array
    {
        return $this->data;
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [];
    }

    /**
     * @return array
     */
    public function handle(): array
    {
        $validator = ValidatorFacade::make($this->data(), $this->rules(), $this->messages());

        $this->check($validator);

        return (new Data($validator->validated(), $this->rules()))->get();
    }

    /**
     * @param \Illuminate\Validation\Validator $validator
     *
     * @throws \App\Services\Validator\Exception
     *
     * @return void
     */
    protected function check(ValidatorService $validator): void
    {
        if ($validator->fails() === false) {
            return;
        }

        $this->notify($validator->errors());
        $this->throwException($validator);
    }

    /**
     * @param \Illuminate\Support\MessageBag $errors
     *
     * @return void
     */
    protected function notify(MessageBag $errors): void
    {
    }

    /**
     * @param \Illuminate\Validation\Validator $validator
     *
     * @throws \App\Services\Validator\Exception
     *
     * @return void
     */
    protected function throwException(ValidatorService $validator): void
    {
        throw new Exception($this->exceptionMessage($validator), null, null, $this->exceptionStatus());
    }

    /**
     * @param \Illuminate\Validation\Validator $validator
     *
     * @return string
     */
    protected function exceptionMessage(ValidatorService $validator): string
    {
        if ($this->request?->wantsJson()) {
            return $this->exceptionMessageJson($validator);
        }

        return $this->exceptionMessageString($validator);
    }

    /**
     * @param \Illuminate\Validation\Validator $validator
     *
     * @return string
     */
    protected function exceptionMessageJson(ValidatorService $validator): string
    {
        $failed = $validator->failed();

        $response = [];

        foreach ($validator->errors()->messages() as $key => $messages) {
            $response[] = $this->exceptionMessageJsonError($key, $failed[$key] ?? [], $messages);
        }

        return json_encode($response);
    }

    /**
     * @param string $key
     * @param array $messages
     * @param array $codes
     *
     * @return array
     */
    protected function exceptionMessageJsonError(string $key, array $codes, array $messages): array
    {
        return [
            'key' => $key,
            'codes' => array_map('str_slug', array_keys($codes)),
            'messages' => $messages,
        ];
    }

    /**
     * @param \Illuminate\Validation\Validator $validator
     *
     * @return string
     */
    protected function exceptionMessageString(ValidatorService $validator): string
    {
        return implode("\n", array_merge([], ...array_values($validator->errors()->messages())));
    }

    /**
     * @return string
     */
    protected function exceptionStatus(): string
    {
        return 'validator';
    }
}
