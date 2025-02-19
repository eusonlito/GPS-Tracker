<?php declare(strict_types=1);

namespace App\Domains\Alarm\Service\Type\Format;

use App\Exceptions\ValidatorException;

abstract class FormatAbstract
{
    /**
     * @return string
     */
    abstract public function code(): string;

    /**
     * @return string
     */
    abstract public function title(): string;

    /**
     * @return string
     */
    abstract public function message(): string;

    /**
     * @return void
     */
    abstract public function validate(): void;

    /**
     * @return array
     */
    abstract public function config(): array;

    /**
     * @return self
     */
    public static function new(): self
    {
        return new static(...func_get_args());
    }

    /**
     * @param array $config
     *
     * @return self
     */
    public function __construct(protected array $config)
    {
    }

    /**
     * @param string $message
     *
     * @return void
     */
    protected function exceptionValidator(string $message): void
    {
        throw new ValidatorException($message);
    }
}
