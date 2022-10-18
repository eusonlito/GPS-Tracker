<?php declare(strict_types=1);

namespace App\Services\Validator;

use Illuminate\Support\Facades\Validator as ValidatorFacade;
use Illuminate\Support\MessageBag;
use Illuminate\Validation\Validator as ValidatorService;

abstract class ValidatorAbstract
{
    /**
     * @var array
     */
    protected array $data;

    /**
     * @return array
     */
    abstract public function rules(): array;

    /**
     * @param array $data
     *
     * @return self
     */
    public function __construct(array $data)
    {
        $this->data = $data;
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

        $errors = $validator->errors();

        $this->notify($errors);
        $this->throwException($errors);
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
     * @param \Illuminate\Support\MessageBag $errors
     *
     * @throws \App\Services\Validator\Exception
     *
     * @return void
     */
    protected function throwException(MessageBag $errors): void
    {
        throw new Exception($this->exceptionMessage($errors), null, null, $this->exceptionStatus($errors));
    }

    /**
     * @param \Illuminate\Support\MessageBag $errors
     *
     * @return string
     */
    protected function exceptionMessage(MessageBag $errors): string
    {
        return implode("\n", array_merge([], ...array_values($errors->messages())));
    }

    /**
     * @param \Illuminate\Support\MessageBag $errors
     *
     * @return string
     */
    protected function exceptionStatus(MessageBag $errors): string
    {
        return implode('|', array_keys($errors->messages()));
    }
}
