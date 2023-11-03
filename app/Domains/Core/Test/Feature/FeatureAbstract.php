<?php declare(strict_types=1);

namespace App\Domains\Core\Test\Feature;

use App\Domains\Core\Test\TestAbstract;

abstract class FeatureAbstract extends TestAbstract
{
    /**
     * @var string
     */
    protected string $route;

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
        return $this->route(null, $this->factoryCreate($model)->id, ...$params);
    }

    /**
     * @param ?string $model = null
     * @param mixed ...$params
     *
     * @return string
     */
    protected function routeFactoryLastModel(?string $model = null, ...$params): string
    {
        return $this->route(null, $this->rowLast($model)->id, ...$params);
    }
}
