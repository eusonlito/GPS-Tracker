<?php declare(strict_types=1);

namespace App\Domains\Core\Model\Traits;

trait JsonColumn
{
    /**
     * @var array
     */
    protected array $jsonColumnCache = [];

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

        if (array_key_exists($cacheKey, $this->jsonColumnCache)) {
            return $this->jsonColumnCache[$cacheKey] ?: $default;
        }

        $value = $this->attributes[$column] ?? null;

        if (empty($value)) {
            return $this->jsonColumnCache($cacheKey, $value, $default);
        }

        if (is_string($value)) {
            $value = json_decode($value, true);
        }

        if (is_array($value) === false) {
            return $this->jsonColumnCache($cacheKey, null, $default);
        }

        if (str_contains($key, '.')) {
            return $this->jsonColumnCache($cacheKey, data_get($value, $key), $default);
        }

        return $this->jsonColumnCache($cacheKey, $value[$key] ?? null, $default);
    }

    /**
     * @param string $key
     * @param mixed $value
     * @param mixed $default
     *
     * @return mixed
     */
    protected function jsonColumnCache(string $key, mixed $value, mixed $default): mixed
    {
        $this->jsonColumnCache[$key] = $value;

        return $value ?: $default;
    }
}
