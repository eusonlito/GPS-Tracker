<?php declare(strict_types=1);

namespace App\Services\Validator;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator as ValidatorFacade;
use Illuminate\Support\MessageBag;
use Illuminate\Validation\Validator as ValidatorService;
use App\Exceptions\ValidatorException;

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
    public function messages(): array
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

        return Data::new($validator->validated(), $this->rules())->get();
    }

    /**
     * @param \Illuminate\Validation\Validator $validator
     *
     * @throws \App\Exceptions\ValidatorException
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
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter
     *
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
     * @throws \App\Exceptions\ValidatorException
     *
     * @return void
     */
    protected function throwException(ValidatorService $validator): void
    {
        throw new ValidatorException(
            message: $this->exceptionMessage($validator),
            code: $this->exceptionCode(),
            status: $this->exceptionStatus(),
            details: $this->exceptionDetails($validator)
        );
    }

    /**
     * @param \Illuminate\Validation\Validator $validator
     *
     * @return string
     */
    protected function exceptionMessage(ValidatorService $validator): string
    {
        return implode("\n", array_merge([], ...array_values($validator->errors()->messages())));
    }

    /**
     * @return int
     */
    protected function exceptionCode(): int
    {
        return 422;
    }

    /**
     * @return string
     */
    protected function exceptionStatus(): string
    {
        return 'validator';
    }

    /**
     * @param \Illuminate\Validation\Validator $validator
     *
     * @return array
     */
    protected function exceptionDetails(ValidatorService $validator): array
    {
        $failed = $validator->failed();

        $response = [];

        foreach ($validator->errors()->messages() as $key => $messages) {
            $response[] = $this->exceptionDetailsMessages($key, $failed[$key] ?? [], $messages);
        }

        return $response;
    }

    /**
     * @param string $key
     * @param array $messages
     * @param array $codes
     *
     * @return array
     */
    protected function exceptionDetailsMessages(string $key, array $codes, array $messages): array
    {
        return [
            'key' => $key,
            'messages' => array_combine(array_map('str_slug', array_keys($codes)), $messages),
        ];
    }
}
