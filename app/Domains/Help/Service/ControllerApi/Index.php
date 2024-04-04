<?php declare(strict_types=1);

namespace App\Domains\Help\Service\ControllerApi;

use Illuminate\Routing\Route;
use Illuminate\Routing\Router;

class Index extends ControllerApiAbstract
{
    /**
     * @return array
     */
    public function data(): array
    {
        return $this->routes();
    }

    /**
     * @return array
     */
    protected function routes(): array
    {
        return array_values(array_filter(array_map(
            $this->route(...),
            app(Router::class)->getRoutes()->getRoutes(),
        )));
    }

    /**
     * @param \Illuminate\Routing\Route $route
     *
     * @return ?array
     */
    protected function route(Route $route): ?array
    {
        if (str_starts_with($route->getName(), 'api.') === false) {
            return null;
        }

        return [
            'name' => $route->getName(),
            'method' => implode('|', $route->methods()),
            'path' => $route->uri(),
        ];
    }
}
