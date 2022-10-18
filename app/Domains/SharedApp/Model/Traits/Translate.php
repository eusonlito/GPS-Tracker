<?php declare(strict_types=1);

namespace App\Domains\SharedApp\Model\Traits;

trait Translate
{
    /**
     * @var array
     */
    protected array $translateCache = [];

    /**
     * @param string $column
     * @param ?string $lang = null
     * @param string|array|null $default = null
     *
     * @return string|array
     */
    public function translate(string $column, ?string $lang = null, string|array|null $default = null): string|array
    {
        $cacheKey = md5(json_encode(func_get_args()));

        if (isset($this->translateCache[$cacheKey])) {
            return $this->translateCache[$cacheKey];
        }

        if (empty($value = $this->attributes[$column])) {
            return $this->translateCache($cacheKey, $default);
        }

        $value = json_decode($value, true);

        if (is_array($value) === false) {
            return $this->translateCache($cacheKey, '');
        }

        return $this->translateCache($cacheKey, $value[$this->translateLocale($lang)] ?? $default);
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
     *
     * @return mixed
     */
    protected function translateCache(string $key, mixed $value): mixed
    {
        return $this->translateCache[$key] = $value;
    }
}
