<?php declare(strict_types=1);

namespace App\Domains\Alarm\Service\Type\Format;

use App\Domains\Position\Model\Position as PositionModel;

abstract class PolygonAbstract extends FormatAbstract
{
    /**
     * @param bool $inside
     *
     * @return bool
     */
    abstract protected function stateValue(bool $inside): bool;

    /**
     * @return array
     */
    public function config(): array
    {
        return [
            'geojson' => ($this->config['geojson'] = $this->configGeoJsonFromText()),
        ];
    }

    /**
     * @return array
     */
    public function configGeoJsonFromText(): array
    {
        if (is_array($this->config['geojson'] ?? null)) {
            return $this->config['geojson'];
        }

        $geojson = json_decode($this->config['geojson'] ?? '[]', true) ?: [];
        $geojson['features'][0]['properties'] = null;

        return $geojson;
    }

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
     * @param \App\Domains\Position\Model\Position $position
     *
     * @return ?bool
     */
    public function state(PositionModel $position): ?bool
    {
        $geojson = $this->config()['geojson'];

        if (empty($geojson['features'][0]['geometry']['coordinates'])) {
            return null;
        }

        $inside = helper()->latitudeLongitudeInsideGeoJson(
            $position->latitude,
            $position->longitude,
            $geojson,
        );

        return $this->stateValue($inside);
    }
}
