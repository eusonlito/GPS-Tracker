<?php declare(strict_types=1);

namespace App\Domains\SharedApp\Model\Traits;

trait JsonColumn
{
    /**
     * @var array
     */
    protected array $jsonColumn = [];

    /**
     * @param string $column
     * @param string $key
     * @param mixed $default = null
     *
     * @return mixed
     */
    public function jsonColumn(string $column, string $key, mixed $default = null): mixed
    {
        $cacheKey = md5(json_encode(func_get_args()));

        if (isset($this->jsonColumn[$cacheKey])) {
            return $this->jsonColumn[$cacheKey];
        }

        if (empty($value = $this->attributes[$column])) {
            return $this->jsonColumnCache($cacheKey, $default);
        }

        if (is_string($value)) {
            $value = json_decode($value, true);
        }

        if (is_array($value) === false) {
            return $this->jsonColumnCache($cacheKey, $default);
        }

        if (str_contains($key, '.')) {
            return $this->jsonColumnCache($cacheKey, data_get($value, $key, $default));
        }

        return $this->jsonColumnCache($cacheKey, $value[$key] ?? $default);
    }

    /**
     * @param string $key
     * @param mixed $value
     *
     * @return mixed
     */
    protected function jsonColumnCache(string $key, mixed $value): mixed
    {
        return $this->jsonColumn[$key] = $value;
    }
}
