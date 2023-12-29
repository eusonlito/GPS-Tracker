<?php declare(strict_types=1);

namespace App\Services\Locate;

class Nominatim extends LocateAbstract
{
    /**
     * @return ?\App\Services\Locate\Resource
     */
    public function locate(): ?Resource
    {
        if (empty($response = $this->request())) {
            return null;
        }

        return new Resource(
            $this->first($response, ['municipality', 'city', 'town', 'village', 'county', 'borough']),
            $this->first($response, ['province', 'state', 'county']),
            $response['country'],
            strtolower($response['country_code'])
        );
    }

    /**
     * @return ?array
     */
    protected function request(): ?array
    {
        return $this->curl()->send()->getBody('array')['address'] ?? null;
    }

    /**
     * @return string
     */
    protected function requestUrl(): string
    {
        return sprintf(
            'https://nominatim.openstreetmap.org/reverse?lat=%s&lon=%s&format=jsonv2&zoom=18&addressdetails=1',
            $this->latitude,
            $this->longitude
        );
    }
}
