<?php declare(strict_types=1);

namespace App\Services\Buffer;

class Byte
{
    /**
     * @var int
     */
    protected int $index = 0;

    /**
     * @var bool
     */
    protected bool $tracking = false;

    /**
     * @var string
     */
    protected string $track = '';

    /**
     * @param string $buffer
     *
     * @return self
     */
    public function __construct(protected string $buffer)
    {
    }

    /**
     * @param ?int $length = null
     * @param ?int $index = null
     *
     * @return self
     */
    public function new(?int $length = null, ?int $index = null): self
    {
        return new static($this->string($length, $index));
    }

    /**
     * @param int $index
     *
     * @return self
     */
    public function index(int $index): self
    {
        $this->index = $index * 2;

        return $this;
    }

    /**
     * @return self
     */
    public function trackStart(): self
    {
        $this->tracking = true;
        $this->track = '';

        return $this;
    }

    /**
     * @return string
     */
    public function trackEnd(): string
    {
        $this->tracking = false;

        return $this->track;
    }

    /**
     * @param ?int $length = null
     * @param ?int $index = null
     *
     * @return string
     */
    public function string(?int $length = null, ?int $index = null): string
    {
        $index = ($index === null) ? $this->index : ($index * 2);
        $length = $length ? ($length * 2) : null;

        $value = substr($this->buffer, $index, $length);

        $this->index = $index + strlen($value);

        if ($this->tracking) {
            $this->track .= $value;
        }

        return $value;
    }

    /**
     * @param ?int $length = null
     * @param ?int $index = null
     *
     * @return int
     */
    public function int(?int $length = null, ?int $index = null): int
    {
        return hexdec($this->string($length, $index));
    }

    /**
     * @return int
     */
    public function length(): int
    {
        return strlen(substr($this->buffer, $this->index)) / 2;
    }

    /**
     * @param mixed $value
     * @param array $values
     *
     * @return int
     */
    public function intIf(mixed $value, array $values): int
    {
        foreach ($values as $each) {
            if ($each === $value) {
                return $this->int(2);
            }
        }

        return $this->int(1);
    }
}
