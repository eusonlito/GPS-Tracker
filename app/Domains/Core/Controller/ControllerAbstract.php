<?php declare(strict_types=1);

namespace App\Domains\Core\Controller;

use Closure;
use Throwable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Domains\Core\Action\ActionFactoryAbstract;
use App\Domains\Core\Model\ModelAbstract;
use App\Domains\Core\Traits\Factory;
use App\Exceptions\NotFoundException;

abstract class ControllerAbstract extends Controller
{
    use Factory;

    /**
     * @return self
     */
    public function __construct()
    {
        $this->middleware($this->setup(...));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     *
     * @return mixed
     */
    protected function setup(Request $request, Closure $next): mixed
    {
        $this->request = $request;
        $this->auth = $request->user();

        $this->init();

        return $next($request);
    }

    /**
     * @return void
     */
    protected function init(): void
    {
    }

    /**
     * @param mixed $data = null
     * @param int $status = 200
     *
     * @return \Illuminate\Http\JsonResponse
     */
    final protected function json($data = null, int $status = 200): JsonResponse
    {
        return response()->json($data, $status);
    }

    /**
     * @param ?\App\Domains\Core\Model\ModelAbstract $row = null
     * @param array $data = []
     *
     * @return \App\Domains\Core\Action\ActionFactoryAbstract
     */
    final protected function action(?ModelAbstract $row = null, array $data = []): ActionFactoryAbstract
    {
        return $this->factory(row: $row)->action($data);
    }

    /**
     * @param string $name
     * @param ?string $target = null
     * @param mixed ...$args
     *
     * @return mixed
     */
    final protected function actionCall(string $name, ?string $target = null, ...$args): mixed
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
    final protected function actionCallClosure(Closure $closure): mixed
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
    protected function actionException(Throwable $e): mixed
    {
        report($e);

        return false;
    }

    /**
     * @param string $message = ''
     *
     * @return void
     */
    final protected function exceptionNotFound(string $message = ''): void
    {
        throw new NotFoundException($message ?: __('common.error.not-found'));
    }
}
