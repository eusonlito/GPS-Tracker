<?php declare(strict_types=1);

namespace App\Exceptions;

use Throwable;
use Illuminate\Foundation\Exceptions\Handler as HandlerVendor;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseSymfony;
use App\Domains\Error\Controller\Index as ErrorController;
use App\Services\Request\Logger;

class Handler extends HandlerVendor
{
    /**
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Validation\ValidationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \App\Exceptions\GenericException::class,
        \App\Services\Validator\Exception::class,
    ];

    /**
     * @param \Throwable $e
     *
     * @return void
     */
    public function report(Throwable $e)
    {
        $this->reportRequest($e);

        parent::report($e);

        if ($this->shouldReport($e)) {
            $this->reportSentry($e);
        }
    }

    /**
     * @param \Throwable $e
     *
     * @return void
     */
    protected function reportRequest(Throwable $e)
    {
        if (config('logging.channels.request.enabled')) {
            Logger::fromException(request(), $e);
        }
    }

    /**
     * @param \Throwable $e
     *
     * @return void
     */
    protected function reportSentry(Throwable $e)
    {
        if (app()->bound('sentry')) {
            app('sentry')->captureException($e);
        }
    }

    /**
     * @param mixed $request
     * @param \Throwable $e
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function render($request, Throwable $e)
    {
        if (config('app.debug')) {
            return $this->renderDebug($request, $e);
        }

        $e = Response::fromException($e);

        if ($request->ajax() || $request->expectsJson()) {
            return $this->renderJson($e);
        }

        return app(ErrorController::class)($e);
    }

    /**
     * @param mixed $request
     * @param \Throwable $e
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function renderDebug($request, Throwable $e): ResponseSymfony
    {
        if ($request->ajax() || $request->expectsJson()) {
            return $this->renderJson(Response::fromException($e));
        }

        return parent::render($request, $e);
    }

    /**
     * @param \Throwable $e
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function renderJson(Throwable $e): JsonResponse
    {
        return response()->json([
            'code' => $e->getCode(),
            'status' => $e->getStatus(),
            'message' => $e->getMessage(),
        ], $e->getCode());
    }
}
