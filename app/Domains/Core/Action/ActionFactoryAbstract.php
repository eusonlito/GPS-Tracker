<?php declare(strict_types=1);

namespace App\Domains\Core\Action;

use Closure;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use App\Domains\Core\Model\ModelAbstract;
use App\Domains\Core\Traits\Factory;
use App\Domains\Core\Validate\ValidateFactoryAbstract;

abstract class ActionFactoryAbstract
{
    use Factory;

    /**
     * @param ?\Illuminate\Http\Request $request = null
     * @param ?\Illuminate\Contracts\Auth\Authenticatable $auth = null
     * @param ?\App\Domains\Core\Model\ModelAbstract $row = null
     * @param array $data = []
     *
     * @return self
     */
    final public function __construct(?Request $request = null, ?Authenticatable $auth = null, ?ModelAbstract $row = null, array $data = [])
    {
        $this->request = $request;
        $this->auth = $auth;
        $this->data = $data;

        if (property_exists($this, 'row')) {
            $this->row = $row;
        }
    }

    /**
     * @param string $class
     * @param ?array $data = []
     *
     * @return \App\Domains\Core\Action\ActionAbstract
     */
    final protected function action(string $class, ?array $data = []): ActionAbstract
    {
        return new $class($this->request, $this->auth, $this->row ?? null, $data ?? $this->data);
    }

    /**
     * @param string $class
     * @param ?array $data = []
     * @param mixed ...$args
     *
     * @return mixed
     */
    final protected function actionHandle(string $class, ?array $data = [], ...$args): mixed
    {
        return $this->action($class, $data ?? $this->data)->handle(...$args);
    }

    /**
     * @param string $class
     * @param ?array $data = []
     * @param mixed ...$args
     *
     * @return mixed
     */
    final protected function actionHandleTransaction(string $class, ?array $data = [], ...$args): mixed
    {
        return $this->transaction(fn () => $this->actionHandle($class, $data ?? $this->data, ...$args));
    }

    /**
     * @param \Closure $closure
     *
     * @return mixed
     */
    final protected function transaction(Closure $closure): mixed
    {
        return $this->connection()->transaction($closure);
    }

    /**
     * @return \App\Domains\Core\Validate\ValidateFactoryAbstract
     */
    final protected function validate(): ValidateFactoryAbstract
    {
        return $this->factory()->validate($this->data);
    }
}
