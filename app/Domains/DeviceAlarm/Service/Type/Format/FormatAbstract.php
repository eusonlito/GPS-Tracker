<?php declare(strict_types=1);

namespace App\Domains\DeviceAlarm\Service\Type\Format;

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
}
