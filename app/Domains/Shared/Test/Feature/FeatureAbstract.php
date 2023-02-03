<?php declare(strict_types=1);

namespace App\Domains\Shared\Test\Feature;

use App\Domains\Shared\Test\TestAbstract;

abstract class FeatureAbstract extends TestAbstract
{
    /**
     * @var string
     */
    protected string $route;

    /**
     * @var string
     */
    protected string $action;

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
     * @param string $name = ''
     *
     * @return array
     */
    protected function action(string $name = ''): array
    {
        return ['_action' => $name ?: $this->action];
    }
}
