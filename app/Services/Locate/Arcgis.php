<?php declare(strict_types=1);

namespace App\Services\Locate;

class Arcgis extends LocateAbstract
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
            $this->first($response, ['City', 'District']),
            $this->first($response, ['Subregion', 'Region']),
            $response['CntryName'],
            strtolower(substr($response['CountryCode'], 0, 2)),
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
            'https://geocode.arcgis.com/arcgis/rest/services/World/GeocodeServer/reverseGeocode?f=pjson&featureTypes=&location=%f,%f',
            $this->longitude,
            $this->latitude,
        );
    }
}
