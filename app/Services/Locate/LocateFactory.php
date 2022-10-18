<?php declare(strict_types=1);

namespace App\Services\Locate;

class LocateFactory
{
    /**
     * @return self
     */
    public static function new(): self
    {
        return new static(...func_get_args());
    }

    /**
     * @param float $latitude
     * @param float $longitude
     *
     * @return self
     */
    public function __construct(protected float $latitude, protected float $longitude)
    {
    }

    /**
     * @return ?\App\Services\Locate\Resource
     */
    public function locate(): ?Resource
    {
        foreach (config('locate.providers') as $provider) {
            if ($resource = $this->provider($provider)->locate()) {
                return $resource;
            }
        }

        return null;
    }

    /**
     * @param string $provider
     *
     * @return \App\Services\Locate\LocateAbstract
     */
    public function provider(string $provider): LocateAbstract
    {
        return new $provider($this->latitude, $this->longitude);
    }
}
