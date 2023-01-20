<?php declare(strict_types=1);

namespace App\Services\Locate;

use App\Services\Http\Curl\Curl;

abstract class LocateAbstract
{
    /**
     * @return ?\App\Services\Locate\Resource
     */
    abstract public function locate(): ?Resource;

    /**
     * @return string
     */
    abstract protected function requestUrl(): string;

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
        $this->latitude = round($latitude, 3);
        $this->longitude = round($longitude, 3);
    }

    /**
     * @return \App\Services\Http\Curl\Curl
     */
    protected function curl(): Curl
    {
        return Curl::new()
            ->setUrl($this->requestUrl())
            ->setException(false)
            ->setLog()
            ->setCache(604800)
            ->setJson()
            ->setJsonResponse();
    }

    /**
     * @param array $data
     * @param array $keys
     *
     * @return string
     */
    protected function first(array $data, array $keys): string
    {
        foreach ($keys as $key) {
            if (empty($data[$key]) === false) {
                return $data[$key];
            }
        }

        return '';
    }
}
