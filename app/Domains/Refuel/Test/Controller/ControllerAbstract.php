<?php declare(strict_types=1);

namespace App\Domains\Refuel\Test\Controller;

use App\Domains\Core\Model\ModelAbstract;
use App\Domains\CoreApp\Test\Feature\FeatureAbstract;
use App\Domains\Refuel\Model\Refuel as Model;

abstract class ControllerAbstract extends FeatureAbstract
{
    /**
     * @return string
     */
    protected function getModelClass(): string
    {
        return Model::class;
    }

    /**
     * @param ?string $model = null
     *
     * @return bool
     */
    protected function modelIsCurrent(?string $model = null): bool
    {
        return empty($model) || ($model === $this->getModelClass());
    }

    /**
     * @param \App\Domains\Core\Model\ModelAbstract $row
     *
     * @return \App\Domains\Core\Model\ModelAbstract
     */
    protected function rowFresh(ModelAbstract $row): ModelAbstract
    {
        $row = $row->fresh();

        if ($this->modelIsCurrent($row::class)) {
            $row->fill($this->factoryData());
        }

        return $row;
    }

    /**
     * @param ?string $model = null
     *
     * @return \App\Domains\Core\Model\ModelAbstract
     */
    protected function rowFirst(?string $model = null): ModelAbstract
    {
        $row = parent::rowFirst($model);

        if ($this->modelIsCurrent($model)) {
            $row->fill($this->factoryData());
        }

        return $row;
    }

    /**
     * @param ?string $model = null
     *
     * @return \App\Domains\Core\Model\ModelAbstract
     */
    protected function rowLast(?string $model = null): ModelAbstract
    {
        $row = parent::rowLast($model);

        if ($this->modelIsCurrent($model)) {
            $row->fill($this->factoryData());
        }

        return $row;
    }

    /**
     * @param ?string $model = null
     * @param array $data = []
     *
     * @return \App\Domains\Core\Model\ModelAbstract
     */
    protected function factoryCreate(?string $model = null, array $data = []): ModelAbstract
    {
        $row = parent::factoryCreate($model, $data);

        if ($this->modelIsCurrent($model)) {
            $row->fill($this->factoryData());
        }

        return $row;
    }

    /**
     * @param ?string $model = null
     * @param array $data = []
     *
     * @return \App\Domains\Core\Model\ModelAbstract
     */
    protected function factoryMake(?string $model = null, array $data = []): ModelAbstract
    {
        $row = parent::factoryMake(data: $data);

        if ($this->modelIsCurrent($model)) {
            $row->fill($this->factoryData($data));
        }

        return $row;
    }

    /**
     * @param array $data = []
     *
     * @return array
     */
    protected function factoryData(array $data = []): array
    {
        return $data + [
            'point' => null,

            'latitude' => 42.34818,
            'longitude' => -7.9126,

            'city_id' => null,
        ];
    }
}
