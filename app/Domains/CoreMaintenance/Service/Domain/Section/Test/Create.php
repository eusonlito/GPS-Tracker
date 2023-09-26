<?php declare(strict_types=1);

namespace App\Domains\CoreMaintenance\Service\Domain\Section\Test;

use Illuminate\Routing\Route;
use Illuminate\Routing\RouteCollection;
use App\Domains\CoreMaintenance\Service\Domain\Section\SectionAbstract;
use App\Services\Filesystem\File;

class Create extends SectionAbstract
{
    /**
     * @return void
     */
    public function handle(): void
    {
        $this->iterate();
    }

    /**
     * @return void
     */
    protected function iterate(): void
    {
        foreach ($this->routes() as $route) {
            $this->route($route);
        }
    }

    /**
     * @return \Illuminate\Routing\RouteCollection
     */
    protected function routes(): RouteCollection
    {
        return app('router')->getRoutes();
    }

    /**
     * @param \Illuminate\Routing\Route $route
     *
     * @return void
     */
    protected function route(Route $route): void
    {
        if ($this->routeIsValid($route) === false) {
            return;
        }

        $file = $this->routeFile($route);

        if (is_file($file)) {
            return;
        }

        File::write($file, Stub::new($this->domain, $route)->contents());
    }

    /**
     * @param \Illuminate\Routing\Route $route
     *
     * @return bool
     */
    protected function routeIsValid(Route $route): bool
    {
        return str_starts_with($route->getControllerClass(), 'App\\Domains\\'.$this->domain.'\\');
    }

    /**
     * @param \Illuminate\Routing\Route $route
     *
     * @return string
     */
    protected function routeFile(Route $route): string
    {
        $name = explode('\\', $route->getControllerClass());
        $name = end($name);

        return $this->base.'/Test/Feature/'.$name.'.php';
    }
}
