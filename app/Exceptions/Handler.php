<?php declare(strict_types=1);

namespace App\Exceptions;

use Throwable;
use Illuminate\Foundation\Exceptions\Handler as HandlerVendor;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response as HttpResponse;
use Sentry;
use App\Domains\Error\Controller\Index as ErrorController;
use App\Services\Request\Logger as RequestLogger;

class Handler extends HandlerVendor
{
    /**
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Validation\ValidationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \App\Exceptions\GenericException::class,
    ];

    /**
     * @return void
     */
    public function register(): void
    {
        $this->reportable(static function (Throwable $e) {
            Sentry\captureException($e);
        });
    }

    /**
     * @param \Throwable $e
     *
     * @return void
     */
    public function report(Throwable $e): void
    {
        $this->reportParent($e);
        $this->reportRequest($e);
    }

    /**
     * @return array
     */
    protected function context(): array
    {
        return parent::context() + [
            'url' => request()->fullUrl(),
            'method' => request()->getMethod(),
        ];
    }

    /**
     * @param \Throwable $e
     *
     * @return void
     */
    protected function reportParent(Throwable $e): void
    {
        parent::report($e);
    }

    /**
     * @param \Throwable $e
     *
     * @return void
     */
    protected function reportRequest(Throwable $e): void
    {
        if (config('logging.channels.request.enabled')) {
            RequestLogger::fromException(request(), $e);
        }
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \Throwable $e
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function render($request, Throwable $e): HttpResponse|JsonResponse
    {
        $e = Response::new($e)->exception();

        if ($request->ajax() || $request->wantsJson()) {
            return $this->renderJson($e);
        }

        if (config('app.debug')) {
            return parent::render($request, $e->getPrevious() ?: $e);
        }

        return app(ErrorController::class)($e);
    }

    /**
     * @param \Throwable $e
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function renderJson(Throwable $e): JsonResponse
    {
        return response()->json($this->renderJsonData($e), $e->getCode());
    }

    /**
     * @param \Throwable $e
     *
     * @return array
     */
    protected function renderJsonData(Throwable $e): array
    {
        return [
            'code' => $e->getCode(),
            'status' => $e->getStatus(),
            'message' => $e->getMessage(),
            'details' => $e->getDetails(),
        ];
    }
}
