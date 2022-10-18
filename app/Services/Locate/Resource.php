<?php declare(strict_types=1);

namespace App\Services\Locate;

class Resource
{
    /**
     * @var array
     */
    protected array $attributes;

    /**
     * @param string $city
     * @param string $state
     * @param string $country
     * @param string $country_code
     *
     * @return self
     */
    public function __construct(string $city, string $state, string $country, string $country_code)
    {
        $this->attributes = get_defined_vars();
    }

    /**
     * @param string $key
     *
     * @return mixed
     */
    public function __get(string $key): mixed
    {
        return $this->attributes[$key] ?? null;
    }

    /**
     * @param string $key
     */
    public function __isset(string $key): bool
    {
        return isset($this->attributes[$key]);
    }
}
