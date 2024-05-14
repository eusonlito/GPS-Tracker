<?php declare(strict_types=1);

namespace App\Domains\Core\Service\Controller;

use Closure;
use ReflectionFunction;
use App\Domains\Core\Model\ModelAbstract;
use App\Exceptions\NotFoundException;
use App\Exceptions\ValidatorException;

abstract class ControllerAbstract
{
    /**
     * @var array
     */
    protected array $cache = [];

    /**
     * @return mixed
     */
    abstract public function data(): mixed;

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
     * @param ?array $default = []
     *
     * @return ?array
     */
    protected function requestArray(string $key, ?array $default = []): ?array
    {
        return (array)$this->request->input($key) ?: $default;
    }

    /**
     * @param string $key
     * @param ?bool $default = false
     *
     * @return ?bool
     */
    protected function requestBool(string $key, ?bool $default = false): ?bool
    {
        return match ($this->request->input($key)) {
            'true', '1' => true,
            'false', '0' => false,
            default => $default,
        };
    }

    /**
     * @param string $key
     * @param ?string $default = null
     *
     * @return ?string
     */
    protected function requestDateToIso(string $key, ?string $default = null): ?string
    {
        return helper()->dateToDate($this->request->input($key), $default);
    }

    /**
     * @param string $key
     * @param ?float $default = 0
     *
     * @return ?float
     */
    protected function requestFloat(string $key, ?float $default = 0): ?float
    {
        return floatval($this->request->input($key)) ?: $default;
    }

    /**
     * @param string $key
     * @param ?int $default = 0
     *
     * @return ?int
     */
    protected function requestInteger(string $key, ?int $default = 0): ?int
    {
        return intval($this->request->input($key)) ?: $default;
    }

    /**
     * @param string $key
     * @param ?string $default = ''
     *
     * @return ?string
     */
    protected function requestString(string $key, ?string $default = ''): ?string
    {
        return strval($this->request->input($key)) ?: $default;
    }

    /**
     * @param array $after = []
     * @param array $before = []
     *
     * @return void
     */
    protected function requestMerge(array $after = [], array $before = []): void
    {
        $this->request->merge($before + $this->request->input() + $after);
    }

    /**
     * @param array $data = []
     * @param ?\App\Domains\Core\Model\ModelAbstract $row = null
     *
     * @return void
     */
    protected function requestMergeWithRow(array $data = [], ?ModelAbstract $row = null): void
    {
        $this->request->merge($this->request->input() + $data + $this->requestMergeWithRowAsArray($row));
    }

    /**
     * @param ?\App\Domains\Core\Model\ModelAbstract $row
     *
     * @return array
     */
    protected function requestMergeWithRowAsArray(?ModelAbstract $row): array
    {
        if ($row) {
            return $row->toArray();
        }

        if (isset($this->row)) {
            return $this->row->toArray();
        }

        return [];
    }

    /**
     * @param string $message = ''
     *
     * @return void
     */
    final protected function exceptionNotFound(string $message = ''): void
    {
        throw new NotFoundException($message ?: __('common.error.not-found'));
    }

    /**
     * @param string $message
     *
     * @return void
     */
    final protected function exceptionValidator(string $message): void
    {
        throw new ValidatorException($message);
    }
}
