<?php declare(strict_types=1);

namespace App\Domains\Configuration\Service\Getter;

class Getter
{
    /**
     * @param array $list
     *
     * @return self
     */
    public function __construct(protected readonly array $list)
    {
    }

    /**
     * @param string $key
     *
     * @return bool
     */
    public function bool(string $key): bool
    {
        return filter_var($this->list[$key] ?? false, FILTER_VALIDATE_BOOLEAN);
    }

    /**
     * @param string $key
     *
     * @return float
     */
    public function float(string $key): float
    {
        return floatval($this->list[$key] ?? 0);
    }

    /**
     * @param string $key
     *
     * @return int
     */
    public function int(string $key): int
    {
        return intval($this->list[$key] ?? 0);
    }

    /**
     * @param string $key
     *
     * @return string
     */
    public function string(string $key): string
    {
        return strval($this->list[$key] ?? '');
    }
}
