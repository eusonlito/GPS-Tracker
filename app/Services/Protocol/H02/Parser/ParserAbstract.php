<?php declare(strict_types=1);

namespace App\Services\Protocol\H02\Parser;

use App\Services\Protocol\Resource\ResourceAbstract;

abstract class ParserAbstract
{
    /**
     * @var bool
     */
    protected bool $bodyIsValid;

    /**
     * @var array
     */
    protected array $values;

    /**
     * @var array
     */
    protected array $cache = [];

    /**
     * @return bool
     */
    abstract public function bodyIsValid(): bool;

    /**
     * @return ?\App\Services\Protocol\Resource\ResourceAbstract
     */
    abstract public function resource(): ?ResourceAbstract;

    /**
     * @return self
     */
    public static function new(): self
    {
        return new static(...func_get_args());
    }

    /**
     * @param string $body
     *
     * @return self
     */
    public function __construct(protected readonly string $body)
    {
    }
}
