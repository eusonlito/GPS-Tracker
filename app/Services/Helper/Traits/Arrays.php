<?php declare(strict_types=1);

namespace App\Services\Helper\Traits;

use RecursiveArrayIterator;
use RecursiveIteratorIterator;
use Stringable;

trait Arrays
{
    /**
     * @param string $key
     *
     * @return string
     */
    public function arrayKeyDot(string $key): string
    {
        return rtrim(str_replace(['][', '[', ']'], ['.', '.', ''], $key), '.');
    }

    /**
     * @param array $array
     * @param array $keys
     *
     * @return array
     */
    public function arrayKeysWhitelist(array $array, array $keys): array
    {
        return array_intersect_key($array, array_flip($keys));
    }

    /**
     * @param array $array
     * @param array $keys
     *
     * @return array
     */
    public function arrayKeysBlacklist(array $array, array $keys): array
    {
        return array_diff_key($array, array_flip($keys));
    }

    /**
     * @param array $array
     * @param array $values
     *
     * @return array
     */
    public function arrayValuesWhitelist(array $array, array $values): array
    {
        return array_intersect($array, $values);
    }

    /**
     * @param array $array
     * @param array $values
     *
     * @return array
     */
    public function arrayValuesBlacklist(array $array, array $values): array
    {
        return array_diff($array, $values);
    }

    /**
     * @param array $array
     * @param ?callable $callback = null
     *
     * @return array
     */
    public function arrayFilterRecursive(array $array, ?callable $callback = null): array
    {
        $callback ??= static fn ($value) => (bool)$value;

        return array_filter(array_map(fn ($value) => is_array($value) ? $this->arrayFilterRecursive($value, $callback) : $value, $array), $callback);
    }

    /**
     * @param array $array
     * @param callable $callback
     * @param bool $values_only = true
     *
     * @return array
     */
    public function arrayMapRecursive(array $array, callable $callback, bool $values_only = true): array
    {
        $keys = array_keys($array);

        $map = function ($value, $key) use ($callback, $values_only) {
            if (is_array($value) === false) {
                return $callback($value, $key);
            }

            if ($values_only) {
                return $this->arrayMapRecursive($value, $callback, $values_only);
            }

            return $this->arrayMapRecursive($callback($value, $key), $callback, $values_only);
        };

        return array_combine($keys, array_map($map, $array, $keys));
    }

    /**
     * @param array $array
     * @param callable $callback
     *
     * @return array
     */
    public function arrayMapKeyValue(array $array, callable $callback): array
    {
        return array_combine($keys = array_keys($array), array_map($callback, $keys, $array));
    }

    /**
     * @param array $array
     *
     * @return array
     */
    public function arrayFlatten(array $array): array
    {
        return iterator_to_array(new RecursiveIteratorIterator(new RecursiveArrayIterator($array)), true);
    }

    /**
     * @param array $array
     * @param array $exclude = []
     * @param array $include = []
     *
     * @return array
     */
    public function arrayValuesRecursive(array $array, array $exclude = [], array $include = []): array
    {
        $result = [];

        foreach ($array as $key => $value) {
            if ($exclude && in_array($key, $exclude)) {
                continue;
            }

            if (is_array($value)) {
                $result = array_merge($result, $this->arrayValuesRecursive($value, $exclude, $include));
            } elseif (empty($include) || in_array($key, $include)) {
                $result[] = $value;
            }
        }

        return $result;
    }

    /**
     * @param array $array
     *
     * @return bool
     */
    public function arrayIsAssociative(array $array): bool
    {
        return ($keys = array_keys($array)) !== array_keys($keys);
    }

    /**
     * @param array $array
     *
     * @return string
     */
    public function arrayHtmlAttributes(array $array): string
    {
        return implode(' ', array_filter(array_map(function ($key, $value) {
            if (is_bool($value)) {
                return $key;
            }

            if (is_string($value) || ($value instanceof Stringable)) {
                return $key.'='.htmlentities((string)$value);
            }

            return '';
        }, array_keys($array), $array)));
    }

    /**
     * @param string $string
     * @param array $list
     *
     * @return bool
     */
    public function startsWithArray(string $string, array $list): bool
    {
        foreach ($list as $each) {
            if (str_starts_with($string, $each)) {
                return true;
            }
        }

        return false;
    }
}
