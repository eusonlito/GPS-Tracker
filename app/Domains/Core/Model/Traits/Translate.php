<?php declare(strict_types=1);

namespace App\Domains\Core\Model\Traits;

trait Translate
{
    /**
     * @var array
     */
    protected array $translateCache = [];

    /**
     * @param string $column
     * @param ?string $lang = null
     * @param mixed $default = null
     *
     * @return mixed
     */
    public function translate(string $column, ?string $lang = null, mixed $default = null): mixed
    {
        $cacheKey = md5(json_encode(func_get_args()));

        if (array_key_exists($cacheKey, $this->translateCache)) {
            return $this->translateCache[$cacheKey] ?: $value;
        }

        $value = $this->attributes[$column] ?? null;

        if (empty($value)) {
            return $this->translateCache($cacheKey, $value, $default);
        }

        $value = json_decode($value, true);

        if (is_array($value) === false) {
            return $this->translateCache($cacheKey, null, $default);
        }

        return $this->translateCache($cacheKey, $value[$this->translateLocale($lang)] ?? null, $default);
    }

    /**
     * @param ?string $lang = null
     *
     * @return string
     */
    protected function translateLocale(?string $lang = null): string
    {
        return $lang ?: app('language')->locale;
    }

    /**
     * @param string $key
     * @param mixed $value
     * @param mixed $default
     *
     * @return mixed
     */
    protected function translateCache(string $key, mixed $value, mixed $default): mixed
    {
        $this->translateCache[$key] = $value;

        return $value ?: $default;
    }
}
