<?php declare(strict_types=1);

namespace App\Domains\Alarm\Service\Type\Format;

abstract class Polygon extends FormatAbstract
{
    /**
     * @return void
     */
    public function validate(): void
    {
        $geojson = $this->config()['geojson'];

        if (empty($geojson)) {
            $this->exceptionValidator(__('alarm-type-polygon.error.geojson'));
        }

        if (empty($geojson['type']) || ($geojson['type'] !== 'FeatureCollection')) {
            $this->exceptionValidator(__('alarm-type-polygon.error.geojson-format'));
        }

        if (empty($geojson['features']) || (count($geojson['features']) !== 1)) {
            $this->exceptionValidator(__('alarm-type-polygon.error.geojson-format'));
        }

        $feature = $geojson['features'][0];

        if (empty($feature['type']) || ($feature['type'] !== 'Feature')) {
            $this->exceptionValidator(__('alarm-type-polygon.error.geojson-format'));
        }

        if (empty($feature['geometry'])) {
            $this->exceptionValidator(__('alarm-type-polygon.error.geojson-format'));
        }

        $geometry = $feature['geometry'];

        if (empty($geometry['type']) || ($geometry['type'] !== 'Polygon')) {
            $this->exceptionValidator(__('alarm-type-polygon.error.geojson-format'));
        }

        if (empty($geometry['coordinates'])) {
            $this->exceptionValidator(__('alarm-type-polygon.error.geojson-format'));
        }

        $coordinates = $geometry['coordinates'];

        if ((is_array($coordinates) === false) || (count($coordinates) !== 1)) {
            $this->exceptionValidator(__('alarm-type-polygon.error.geojson-format'));
        }
    }

    /**
     * @return array
     */
    public function config(): array
    {
        if (is_array($this->config['geojson'] ?? '') === false) {
            $this->config['geojson'] = $this->configGeoJsonFromText();
        }

        return [
            'geojson' => $this->config['geojson'],
        ];
    }

    /**
     * @return array
     */
    public function configGeoJsonFromText(): array
    {
        $geojson = json_decode($this->config['geojson'] ?? '[]', true) ?: [];
        $geojson['features'][0]['properties'] = null;

        return $geojson;
    }
}
