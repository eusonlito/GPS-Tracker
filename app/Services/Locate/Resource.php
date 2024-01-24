<?php declare(strict_types=1);

namespace App\Services\Locate;

/**
 * @property string $city
 * @property string $state
 * @property string $country
 * @property string $country_code
 */
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
        $this->attributes = [
            'city' => $city,
            'state' => $state,
            'country' => $country,
            'country_code' => $country_code,
        ];
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
