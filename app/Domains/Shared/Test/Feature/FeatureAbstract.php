<?php declare(strict_types=1);

namespace App\Domains\Shared\Test\Feature;

use App\Domains\Shared\Model\ModelAbstract;
use App\Domains\Shared\Test\TestAbstract;

abstract class FeatureAbstract extends TestAbstract
{
    /**
     * @return string
     */
    abstract protected function getModelClass(): string;

    /**
     * @var string
     */
    protected string $route;

    /**
     * @var string
     */
    protected string $action;

    /**
     * @param ?string $model = null
     *
     * @return \App\Domains\Shared\Model\ModelAbstract
     */
    protected function factoryCreateModel(?string $model = null): ModelAbstract
    {
        return $this->factoryCreate($model ?? $this->getModelClass());
    }

    /**
     * @param ?string $name = null
     * @param mixed ...$params
     *
     * @return string
     */
    protected function route(?string $name = null, ...$params): string
    {
        return (string)route($this->route.($name ? ('.'.$name) : ''), $params);
    }

    /**
     * @param ?string $model = null
     * @param mixed ...$params
     *
     * @return string
     */
    protected function routeFactoryCreateModel(?string $model = null, ...$params): string
    {
        return $this->route(null, $this->factoryCreateModel($model)->id, ...$params);
    }

    /**
     * @param string $name = ''
     *
     * @return array
     */
    protected function action(string $name = ''): array
    {
        return ['_action' => $name ?: $this->action];
    }
}
