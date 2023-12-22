<?php declare(strict_types=1);

namespace App\Services\Locate;

class Gisgraphy extends LocateAbstract
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
            $this->first($response, ['city', 'citySubdivision']),
            $this->first($response, ['adm2Name', 'state']),
            $this->resourceCountry($response),
            strtolower($response['countryCode'])
        );
    }

    /**
     * @return ?array
     */
    protected function request(): ?array
    {
        return $this->curl()->send()->getBody('array')['result'][0] ?? null;
    }

    /**
     * @return string
     */
    protected function requestUrl(): string
    {
        return sprintf(
            'https://services.gisgraphy.com/reversegeocoding/search?format=json&lat=%s&lng=%s',
            $this->latitude,
            $this->longitude
        );
    }

    /**
     * @param array $response
     *
     * @return string
     */
    protected function resourceCountry(array $response): string
    {
        $full = explode(',', $response['formatedFull']);

        return trim(end($full));
    }
}
