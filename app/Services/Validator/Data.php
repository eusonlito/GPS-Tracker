<?php declare(strict_types=1);

namespace App\Services\Validator;

use Stringable;

class Data
{
    /**
     * @var array
     */
    protected array $data = [];

    /**
     * @var array
     */
    protected array $rules = [];

    /**
     * @var bool
     */
    protected bool $all = true;

    /**
     * @return self
     */
    public static function new(): self
    {
        return new static(...func_get_args());
    }

    /**
     * @param array $data
     * @param array $rules
     * @param bool $all = true
     *
     * @return self
     */
    public function __construct(array $data, array $rules, bool $all = true)
    {
        $this->data = $this->data($data);
        $this->rules = $this->rules($rules);
        $this->all = $all;
    }

    /**
     * @return array
     */
    public function get(): array
    {
        return $this->castRules($this->data, $this->rules);
    }

    /**
     * @param array $data
     *
     * @return array
     */
    public function data(array $data): array
    {
        return array_filter($data, static fn ($key) => str_starts_with((string)$key, '_') === false, ARRAY_FILTER_USE_KEY);
    }

    /**
     * @param array $rules
     *
     * @return array
     */
    protected function rules(array $rules): array
    {
        foreach ($rules as $key => $rule) {
            if (is_array($rule)) {
                $rules[$key] = implode('|', array_filter($rule, 'is_string'));
            }
        }

        $rulesNew = [];

        foreach ($rules as $key => $value) {
            array_set($rulesNew, $key, $value);
        }

        return $rulesNew;
    }

    /**
     * @param array $data
     * @param array $rules
     *
     * @return array
     */
    protected function castRules(array $data, array $rules): array
    {
        foreach ($rules as $key => $rule) {
            if ($key === '*') {
                $data = $this->castRulesArray($data, $rule);
            } else {
                $data = $this->castRule($data, $key, $rule);
            }
        }

        return $data;
    }

    /**
     * @param array $data
     * @param string|int $key
     * @param string|array $rule
     *
     * @return array
     */
    protected function castRule(array $data, string|int $key, string|array $rule): array
    {
        $value = $data[$key] ?? null;

        if (is_array($rule)) {
            $value = $this->castRules(is_array($value) ? $value : [], $rule);
        } else {
            $value = $this->cast($value, $rule);
        }

        $data[$key] = $value;

        return $data;
    }

    /**
     * @param array $data
     * @param array|string $rules
     *
     * @return array
     */
    protected function castRulesArray(array $data, array|string $rules): array
    {
        if (empty($data)) {
            return [];
        }

        if (is_string($rules)) {
            return $this->castRulesArrayString($data, $rules);
        }

        foreach ($data as &$values) {
            foreach ($rules as $name => $rule) {
                $values = $this->castRule($values, $name, $rule);
            }
        }

        return $data;
    }

    /**
     * @param array $data
     * @param string $rules
     *
     * @return array
     */
    protected function castRulesArrayString(array $data, string $rules): array
    {
        $rules = explode('|', $rules);

        foreach ($data as &$values) {
            foreach ($rules as $rule) {
                $values = $this->cast($values, $rule);
            }
        }

        return $data;
    }

    /**
     * @param mixed $value
     * @param string $rule
     *
     * @return mixed
     */
    protected function cast(mixed $value, string $rule): mixed
    {
        $rule = explode('|', $rule);

        if ($this->castIsNullable($value, $rule)) {
            return null;
        }

        if (in_array('boolean', $rule, true)) {
            return filter_var($value, FILTER_VALIDATE_BOOLEAN);
        }

        if (in_array('integer', $rule, true)) {
            return (int)$value;
        }

        if (in_array('numeric', $rule, true)) {
            return (float)$value;
        }

        if (in_array('string', $rule, true)) {
            return (string)$value;
        }

        if (in_array('array', $rule, true)) {
            return (array)$value;
        }

        return $value;
    }

    /**
     * @param mixed $value
     * @param array $rule
     *
     * @return bool
     */
    protected function castIsNullable(mixed $value, array $rule): bool
    {
        if ($value) {
            return false;
        }

        if (in_array('nullable', $rule, true) === false) {
            return false;
        }

        if (is_null($value)) {
            return true;
        }

        if ((is_string($value) === false) && (($value instanceof Stringable) === false)) {
            return false;
        }

        return strlen(strval($value)) === 0;
    }
}
