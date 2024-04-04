<?php declare(strict_types=1);

namespace App\Exceptions;

use Throwable;
use Illuminate\Foundation\Exceptions\Handler as HandlerVendor;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response as HttpResponse;
use Sentry;
use App\Domains\Error\Controller\Index as ErrorController;

class Handler extends HandlerVendor
{
    /**
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        AuthenticationException::class,
        ValidatorException::class,
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
