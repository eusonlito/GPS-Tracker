<?php declare(strict_types=1);

namespace App\Domains\Help\Service\ControllerApi;

use Illuminate\Routing\Route;
use Illuminate\Routing\Router;

class Detail extends ControllerApiAbstract
{
    /**
     * @var \Illuminate\Routing\Route
     */
    protected Route $route;

    /**
     * @var string
     */
    protected string $domain;

    /**
     * @var string
     */
    protected string $controller;

    /**
     * @param string $name
     *
     * @return self
     */
    public function __construct(protected string $name)
    {
        $this->route();
        $this->domain();
        $this->controller();
    }

    /**
     * @return void
     */
    protected function route(): void
    {
        foreach (app(Router::class)->getRoutes()->getRoutes() as $route) {
            if ($route->getName() === $this->name) {
                $this->route = $route;
                break;
            }
        }

        if (empty($this->route)) {
            abort(404);
        }
    }

    /**
     * @return void
     */
    protected function domain(): void
    {
        $this->domain = explode('\\', $this->route->getControllerClass())[2];
    }

    /**
     * @return void
     */
    protected function controller(): void
    {
        $this->controller = explode('\\', $this->route->getControllerClass())[4];
    }

    /**
     * @return array
     */
    public function data(): array
    {
        return $this->detail();
    }

    /**
     * @return array
     */
    protected function detail(): array
    {
        return array_filter([
            'name' => $this->route->getName(),
            'method' => implode('|', $this->route->methods()),
            'path' => $this->route->uri(),
            'filters' => $this->filters(),
            'validation' => $this->validation(),
        ]);
    }

    /**
     * @return ?array
     */
    protected function filters(): ?array
    {
        if (in_array('GET', $this->route->methods()) === false) {
            return null;
        }

        $contents = $this->fileContents('Service/ControllerApi');

        if (empty($contents)) {
            return null;
        }

        preg_match_all('/this\->request[^\(]+\(\'([^\']+)\'/', $contents, $matches);

        return $matches[1];
    }

    /**
     * @return ?array
     */
    protected function validation(): ?array
    {
        $methods = $this->route->methods();

        if ((in_array('POST', $methods) === false) && (in_array('PATCH', $methods) === false)) {
            return null;
        }

        $class = $this->class('Validate');

        if (empty($class)) {
            return null;
        }

        return (new $class(null, []))->rules();
    }

    /**
     * @param string $path
     *
     * @return ?string
     */
    protected function class(string $path): ?string
    {
        $class = '\\App\\Domains\\'.$this->domain.'\\'.$path.'\\'.$this->controller;

        return class_exists($class) ? $class : null;
    }

    /**
     * @param string $path
     *
     * @return ?string
     */
    protected function file(string $path): ?string
    {
        $file = base_path('app/Domains/'.$this->domain.'/'.$path.'/'.$this->controller.'.php');

        return is_file($file) ? $file : null;
    }

    /**
     * @param string $path
     *
     * @return ?string
     */
    protected function fileContents(string $path): ?string
    {
        $file = $this->file($path);

        return $file ? file_get_contents($file) : null;
    }
}
