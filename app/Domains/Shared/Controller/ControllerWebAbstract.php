<?php declare(strict_types=1);

namespace App\Domains\Shared\Controller;

use Closure;
use Throwable;
use Illuminate\Http\Response;
use Eusonlito\LaravelMeta\Facade as Meta;
use App\Domains\SharedApp\Model\ModelAbstract;
use App\Services\Html\Alert;
use App\Services\Request\Response as ResponseService;

abstract class ControllerWebAbstract extends ControllerAbstract
{
    /**
     * @return void
     */
    protected function init(): void
    {
        $this->initDefault();
        $this->initCustom();
    }

    /**
     * @return void
     */
    protected function initDefault(): void
    {
        $this->initViewShare();
    }

    /**
     * @return void
     */
    protected function initViewShare(): void
    {
        $route = $this->request->route();

        view()->share([
            'ROUTE' => ($route ? $route->getName() : ''),
            'AUTH' => $this->auth,
            'REQUEST' => $this->request,
        ]);
    }

    /**
     * @return void
     */
    protected function initCustom(): void
    {
    }

    /**
     * @param string $name
     * @param ?string $value
     *
     * @return void
     */
    protected function meta(string $name, ?string $value): void
    {
        if ($value) {
            Meta::set($name, $value);
        }
    }

    /**
     * @param string $page
     * @param array $data = []
     * @param ?int $status = null
     *
     * @return \Illuminate\Http\Response
     */
    protected function page(string $page, array $data = [], ?int $status = null): Response
    {
        return response()->view('domains.'.$page, $data, ResponseService::status($status));
    }

    /**
     * @param array $data = []
     * @param ?\App\Domains\Shared\Model\ModelAbstract $row = null
     *
     * @return void
     */
    final protected function requestMergeWithRow(array $data = [], ?ModelAbstract $row = null): void
    {
        $this->request->merge($this->request->input() + $data + ($row ?? $this->row)->toArray());
    }

    /**
     * @param string $name
     *
     * @return mixed
     */
    final protected function actionIfExists(string $name)
    {
        if ($this->request->input('_action') === $name) {
            return call_user_func_array([$this, 'actionCall'], func_get_args());
        }
    }

    /**
     * @param string $name
     *
     * @return mixed
     */
    final protected function actionPost(string $name)
    {
        if ($this->request->isMethod('post')) {
            return $this->actionIfExists($name, ...func_get_args());
        }
    }

    /**
     * @param string $name
     * @param ?string $target = null
     * @param mixed ...$args
     *
     * @return mixed
     */
    final protected function actionCall(string $name, ?string $target = null, ...$args)
    {
        try {
            return call_user_func_array([$this, $target ?: $name], $args);
        } catch (Throwable $e) {
            return $this->actionException($e);
        }
    }

    /**
     * @param \Closure $closure
     *
     * @return mixed
     */
    final protected function actionCallClosure(Closure $closure)
    {
        try {
            return $closure();
        } catch (Throwable $e) {
            return $this->actionException($e);
        }
    }

    /**
     * @param \Throwable $e
     *
     * @return mixed
     */
    final protected function actionException(Throwable $e)
    {
        report($e);

        return Alert::exception($this->request, $e);
    }

    /**
     * @param string $status
     * @param string $message
     *
     * @return mixed
     */
    final protected function sessionMessage(string $status, string $message)
    {
        return Alert::{$status}($message);
    }
}
