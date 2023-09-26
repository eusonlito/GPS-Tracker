<?php declare(strict_types=1);

namespace App\Domains\Core\Service\Factory;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use App\Domains\Core\Action\ActionFactoryAbstract;
use App\Domains\Core\Mail\MailFactoryAbstract;
use App\Domains\Core\Model\ModelAbstract;
use App\Domains\Core\Validate\ValidateFactoryAbstract;

class Factory
{
    /**
     * @var string
     */
    protected string $namespace;

    /**
     * @var ?\Illuminate\Http\Request
     */
    protected ?Request $request;

    /**
     * @var ?\Illuminate\Contracts\Auth\Authenticatable
     */
    protected ?Authenticatable $auth;

    /**
     * @var ?\App\Domains\Core\Model\ModelAbstract
     */
    protected ?ModelAbstract $row;

    /**
     * @param string $namespace
     * @param ?\Illuminate\Http\Request $request = null
     * @param ?\Illuminate\Contracts\Auth\Authenticatable $auth = null
     *
     * @return self
     */
    public function __construct(
        string $namespace,
        ?Request $request = null,
        ?Authenticatable $auth = null,
        ?ModelAbstract $row = null
    ) {
        $this->namespace = $namespace;
        $this->request = $request;
        $this->auth = $auth;
        $this->row = $row;
    }

    /**
     * @param array $data = []
     *
     * @return \App\Domains\Core\Action\ActionFactoryAbstract
     */
    public function action(array $data = []): ActionFactoryAbstract
    {
        return $this->new($this->classFactory('Action'), $this->request, $this->auth, $this->row, $this->data($data));
    }

    /**
     * @param array $data = []
     *
     * @return \App\Domains\Core\Validate\ValidateFactoryAbstract
     */
    public function validate(array $data = []): ValidateFactoryAbstract
    {
        return $this->new($this->classFactory('Validate'), $this->request, $this->data($data));
    }

    /**
     * @return \App\Domains\Core\Mail\MailFactoryAbstract
     */
    public function mail(): MailFactoryAbstract
    {
        return $this->new($this->classFactory('Mail'), $this->auth);
    }

    /**
     * @param string $view
     * @param mixed $data
     * @param mixed ...$args
     *
     * @return ?array
     */
    public function fractal(string $view, $data, ...$args): ?array
    {
        return $this->new($this->classFactory('Fractal'))->transform($view, $data, ...$args);
    }

    /**
     * @param string $folder
     * @param ?string $class = null
     *
     * @return string
     */
    protected function class(string $folder, ?string $class = null): string
    {
        return $this->namespace.'\\'.$folder.'\\'.($class ?: $folder);
    }

    /**
     * @param string $name
     *
     * @return string
     */
    protected function classFactory(string $name): string
    {
        return $this->class($name).'Factory';
    }

    /**
     * @param string $class
     * @param mixed $args
     *
     * @return object
     */
    protected static function new(string $class, ...$args): object
    {
        return new $class(...$args);
    }

    /**
     * @param array $data = []
     *
     * @return array
     */
    protected function data(array $data = []): array
    {
        if ($data) {
            return $data;
        }

        if (empty($this->request)) {
            return [];
        }

        if (empty($this->request->route())) {
            return $this->request->all();
        }

        return array_merge($this->request->route()->parameters(), $this->request->all());
    }
}
