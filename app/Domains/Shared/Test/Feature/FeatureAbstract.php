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
     * @return \App\Domains\Shared\Model\ModelAbstract
     */
    protected function factoryCreateModel(): ModelAbstract
    {
        return $this->factoryCreate($this->getModelClass());
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
     * @param mixed ...$params
     *
     * @return string
     */
    protected function routeFactoryCreateModelId(...$params): string
    {
        return $this->route(null, $this->factoryCreateModel()->id, ...$params);
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
