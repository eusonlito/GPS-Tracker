<?php declare(strict_types=1);

namespace App\Domains\Maintenance\Service\Domain\Section\Test;

use Illuminate\Routing\Route;
use Illuminate\Routing\RouteCollection;
use App\Domains\Maintenance\Service\Domain\Section\SectionAbstract;
use App\Exceptions\UnexpectedValueException;
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

        $stub = $this->stubContents($this->routeStub($route));
        $controller = str_replace('.php', '', basename($file));

        File::write($file, $this->stubContentsReplace($stub, $route->getName(), $controller));
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

    /**
     * @param \Illuminate\Routing\Route $route
     *
     * @return string
     */
    protected function routeStub(Route $route): string
    {
        $methods = $route->methods();

        $get = in_array('GET', $methods);
        $post = in_array('POST', $methods);

        $middlewares = $route->middleware();

        $userAuth = in_array('user-auth', $middlewares);
        $userAuthAdmin = in_array('user-auth-admin', $middlewares);

        $id = in_array('id', $route->parameterNames());

        if ($get && $post && $userAuthAdmin && $id) {
            return 'GetPostUserAuthAdminId';
        }

        if ($get && $post && $userAuthAdmin) {
            return 'GetPostUserAuthAdmin';
        }

        if ($get && $userAuthAdmin && $id) {
            return 'GetUserAuthAdminId';
        }

        if ($get && $userAuthAdmin) {
            return 'GetUserAuthAdmin';
        }

        if ($post && $userAuthAdmin && $id) {
            return 'PostUserAuthAdminId';
        }

        if ($post && $userAuthAdmin) {
            return 'PostUserAuthAdmin';
        }

        if ($get && $post && $userAuth && $id) {
            return 'GetPostUserAuthId';
        }

        if ($get && $post && $userAuth) {
            return 'GetPostUserAuth';
        }

        if ($get && $userAuth && $id) {
            return 'GetUserAuthId';
        }

        if ($get && $userAuth) {
            return 'GetUserAuth';
        }

        if ($post && $userAuth && $id) {
            return 'PostUserAuthId';
        }

        if ($post && $userAuth) {
            return 'PostUserAuth';
        }

        if ($get && $post && $id) {
            return 'GetPostId';
        }

        if ($get && $post) {
            return 'GetPost';
        }

        if ($get && $id) {
            return 'GetId';
        }

        if ($get) {
            return 'Get';
        }

        if ($post && $id) {
            return 'PostId';
        }

        if ($post) {
            return 'Post';
        }

        throw new UnexpectedValueException(sprintf('Invaid Route Stub Combination for %s', $route->getName()));
    }

    /**
     * @param string $stub
     *
     * @return string
     */
    protected function stubContents(string $stub): string
    {
        return file_get_contents(__DIR__.'/stub/'.$stub.'.stub');
    }

    /**
     * @param string $string
     * @param string $route,
     * @param string $controller
     *
     * @return string
     */
    protected function stubContentsReplace(string $string, string $route, string $controller): string
    {
        return strtr($string, [
            '{{ domain }}' => $this->domain,
            '__domain__' => $this->domain,
            '{{ name }}' => $this->name,
            '__name__' => $this->name,
            '{{ table }}' => $this->table,
            '__table__' => $this->table,
            '{{ route }}' => $route,
            '__route__' => $route,
            '{{ controller }}' => $controller,
            '__controller__' => $controller,
        ]);
    }
}
