<?php declare(strict_types=1);

namespace App\Domains\Core\Model\Traits;

trait Translation
{
    use Translate;

    /**
     * @var array
     */
    protected array $translationCache = [];

    /**
     * @param ?string $key
     * @param string|bool|null $lang = null
     * @param mixed $default = null
     *
     * @return mixed
     */
    public function translation(?string $key, string|bool|null $lang = null, mixed $default = null): mixed
    {
        $cacheKey = md5(json_encode(func_get_args()));

        if (array_key_exists($cacheKey, $this->translationCache)) {
            return $this->translationCache[$cacheKey] ?: $default;
        }

        if ($lang === false) {
            return $this->translationCache($cacheKey, $this->translationAny($key), $default);
        }

        $translation = $this->translate('translation', $lang, []);

        if ($key === null) {
            return $this->translationCache($cacheKey, $translation, $default);
        }

        if (str_contains($key, '.')) {
            return $this->translationCache($cacheKey, data_get($translation, $key), $default);
        }

        return $this->translationCache($cacheKey, $translation[$key] ?? null, $default);
    }

    /**
     * @param string $key
     *
     * @return mixed
     */
    protected function translationAny(string $key): mixed
    {
        if ($translation = $this->translation($key, null)) {
            return $translation;
        }

        if (str_contains($key, '.') === false) {
            return current(array_filter(array_column($this->translation, $key))) ?: $default;
        }

        foreach ($this->translation as $each) {
            if ($value = data_get($each, $key)) {
                return $value;
            }
        }

        return null;
    }

    /**
     * @param string $key
     * @param mixed $value
     * @param mixed $default
     *
     * @return mixed
     */
    protected function translationCache(string $key, mixed $value, mixed $default): mixed
    {
        $this->translationCache[$key] = $value;

        return $value ?: $default;
    }
}
