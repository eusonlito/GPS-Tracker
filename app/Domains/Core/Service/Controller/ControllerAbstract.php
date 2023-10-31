<?php declare(strict_types=1);

namespace App\Domains\Core\Service\Controller;

use Closure;
use ReflectionFunction;
use App\Domains\Core\Model\ModelAbstract;

abstract class ControllerAbstract
{
    /**
     * @var array
     */
    protected array $cache = [];

    /**
     * @return array
     */
    abstract public function data(): array;

    /**
     * @return self
     */
    public static function new(): self
    {
        return new static(...func_get_args());
    }

    /**
     * @param \Closure $callback
     *
     * @return mixed
     */
    protected function cache(Closure $callback): mixed
    {
        $key = $this->cacheKey($callback);

        if (array_key_exists($key, $this->cache) === false) {
            $this->cache[$key] = $callback();
        }

        return $this->cache[$key];
    }

    /**
     * @param \Closure $callback
     *
     * @return string
     */
    protected function cacheKey(Closure $callback): string
    {
        $r = new ReflectionFunction($callback);

        return md5($r->getFileName().$r->getStartLine().$r->getEndLine());
    }

    /**
     * @param string $key
     * @param ?array $default = null
     *
     * @return ?array
     */
    protected function requestArray(string $key, ?array $default = null): ?array
    {
        return (array)$this->request->input($key) ?: $default;
    }

    /**
     * @param string $key
     * @param ?bool $default = null
     *
     * @return ?bool
     */
    protected function requestBool(string $key, ?bool $default = null): ?bool
    {
        return match ($this->request->input($key)) {
            'true', '1' => true,
            'false', '0' => false,
            default => $default,
        };
    }

    /**
     * @param array $data = []
     * @param ?\App\Domains\Core\Model\ModelAbstract $row = null
     *
     * @return void
     */
    final protected function requestMergeWithRow(array $data = [], ?ModelAbstract $row = null): void
    {
        $this->request->merge($this->request->input() + $data + $this->requestMergeWithRowAsArray($row));
    }

    /**
     * @param ?\App\Domains\Core\Model\ModelAbstract $row
     *
     * @return array
     */
    final protected function requestMergeWithRowAsArray(?ModelAbstract $row): array
    {
        if ($row) {
            return $row->toArray();
        }

        if (isset($this->row)) {
            return $this->row->toArray();
        }

        return [];
    }
}
