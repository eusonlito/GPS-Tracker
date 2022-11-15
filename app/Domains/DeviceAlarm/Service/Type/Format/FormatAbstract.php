<?php declare(strict_types=1);

namespace App\Domains\DeviceAlarm\Service\Type\Format;

use App\Domains\Position\Model\Position as PositionModel;

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
     * @param \App\Domains\Position\Model\Position $position
     *
     * @return bool
     */
    abstract public function checkPosition(PositionModel $position): bool;

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
