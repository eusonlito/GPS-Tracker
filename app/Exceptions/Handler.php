<?php declare(strict_types=1);

namespace App\Exceptions;

use Throwable;
use Illuminate\Foundation\Exceptions\Handler as HandlerVendor;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response as ResponseVendor;
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
     * @param \Illuminate\Http\Request $request
     * @param \Throwable $e
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function render($request, Throwable $e): ResponseVendor|JsonResponse
    {
        $e = Response::fromException($e);

        if ($request->ajax() || $request->wantsJson()) {
            return $this->renderJson($request, $e);
        }

        if (config('app.debug')) {
            return parent::render($request, $e);
        }

        return app(ErrorController::class)($e);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \Throwable $e
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function renderJson(Request $request, Throwable $e): JsonResponse
    {
        return response()->json($this->renderJsonResponse($request, $e), $e->getCode());
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \Throwable $e
     *
     * @return array
     */
    protected function renderJsonResponse(Request $request, Throwable $e): array
    {
        $data = $this->renderJsonResponseData($e);

        if ($request->wantsJson()) {
            $data['message'] = json_decode($data['message']);
        }

        return $data;
    }

    /**
     * @param \Throwable $e
     *
     * @return array
     */
    protected function renderJsonResponseData(Throwable $e): array
    {
        return [
            'code' => $e->getCode(),
            'status' => $e->getStatus(),
            'message' => $e->getMessage(),
        ];
    }
}
