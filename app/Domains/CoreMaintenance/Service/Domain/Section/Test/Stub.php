<?php declare(strict_types=1);

namespace App\Domains\CoreMaintenance\Service\Domain\Section\Test;

use Closure;
use Illuminate\Routing\Route;
use App\Exceptions\UnexpectedValueException;

class Stub
{
    /**
     * @var string
     */
    protected string $name;

    /**
     * @var string
     */
    protected string $controller;

    /**
     * @var string
     */
    protected string $controllerFile;

    /**
     * @var string
     */
    protected string $action;

    /**
     * @var string
     */
    protected string $code;

    /**
     * @return self
     */
    public static function new(): self
    {
        return new static(...func_get_args());
    }

    /**
     * @param string $domain
     * @param \Illuminate\Routing\Route $route
     *
     * @return self
     */
    public function __construct(protected string $domain, protected Route $route)
    {
        $this->name();
        $this->controller();
        $this->action();
    }

    /**
     * @return void
     */
    protected function name(): void
    {
        $this->name = snake_case($this->domain, '-');
    }

    /**
     * @return void
     */
    protected function controller(): void
    {
        $this->controllerFile = preg_replace('/^App/', 'app', $this->route->getControllerClass());
        $this->controllerFile = str_replace('\\', '/', $this->controllerFile);
        $this->controllerFile = base_path($this->controllerFile.'.php');

        $this->controller = str_replace('.php', '', basename($this->controllerFile));
    }

    /**
     * @return void
     */
    protected function action(): void
    {
        preg_match('/\->action[A-Za-z]+\(\'([a-zA-Z0-9]+)/', file_get_contents($this->controllerFile), $matches);

        $this->action = $matches[1] ?? '';
    }

    /**
     * @return string
     */
    public function contents(): string
    {
        $this->code = $this->stubContents($this->base());

        while (preg_match($this->includeExpression(), $this->code)) {
            $this->code = preg_replace_callback($this->includeExpression(), $this->includeReplace(), $this->code);
        }

        return $this->stubContentsReplace($this->code);
    }

    /**
     * @return string
     */
    protected function includeExpression(): string
    {
        return '/\{\{\s((function|code)\/[a-zA-Z]+)\s}}/';
    }

    /**
     * @return \Closure
     */
    protected function includeReplace(): Closure
    {
        return fn ($matches) => $this->includeReplaceMatch($matches);
    }

    /**
     * @param array $matches
     *
     * @return string
     */
    protected function includeReplaceMatch(array $matches): string
    {
        $spaces = $matches[2] === 'function' ? 4 : 8;

        $contents = $this->stubContents($matches[1]);
        $contents = preg_replace('/^/m', str_repeat(' ', $spaces), $contents);

        return trim($contents);
    }

    /**
     * @return string
     */
    protected function base(): string
    {
        $get = $this->routeIsMethod('GET');
        $post = $this->routeIsMethod('POST');

        $auth = $this->routeHasMiddleware('user-auth');
        $authAdmin = $this->routeHasMiddleware('user-auth-admin');

        $id = $this->routeHasParameter('id');

        if ($get && $post && $authAdmin && $id) {
            return 'GetPostAuthAdminId';
        }

        if ($get && $post && $authAdmin) {
            return 'GetPostAuthAdmin';
        }

        if ($get && $authAdmin && $id) {
            return 'GetAuthAdminId';
        }

        if ($get && $authAdmin) {
            return 'GetAuthAdmin';
        }

        if ($post && $authAdmin && $id) {
            return 'PostAuthAdminId';
        }

        if ($post && $authAdmin) {
            return 'PostAuthAdmin';
        }

        if ($get && $post && $auth && $id) {
            return 'GetPostAuthId';
        }

        if ($get && $post && $auth) {
            return 'GetPostAuth';
        }

        if ($get && $auth && $id) {
            return 'GetAuthId';
        }

        if ($get && $auth) {
            return 'GetAuth';
        }

        if ($post && $auth && $id) {
            return 'PostAuthId';
        }

        if ($post && $auth) {
            return 'PostAuth';
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

        throw new UnexpectedValueException(sprintf('Invaid Route Stub Combination for %s', $this->route->getName()));
    }

    /**
     * @param string $method
     *
     * @return bool
     */
    protected function routeIsMethod(string $method): bool
    {
        return in_array(strtoupper($method), $this->route->methods());
    }

    /**
     * @param string $middleware
     *
     * @return bool
     */
    protected function routeHasMiddleware(string $middleware): bool
    {
        return in_array($middleware, $this->route->middleware());
    }

    /**
     * @param string $parameter
     *
     * @return bool
     */
    protected function routeHasParameter(string $parameter): bool
    {
        return in_array($parameter, $this->route->parameterNames());
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
     *
     * @return string
     */
    protected function stubContentsReplace(string $string): string
    {
        return preg_replace('/^\s+$/m', '', strtr($string, [
            '{{ domain }}' => $this->domain,
            '{{ controller }}' => $this->controller,
            '{{ name }}' => $this->name,
            '{{ route }}' => $this->route->getName(),
            '{{ action }}' => $this->action,
        ]));
    }
}
