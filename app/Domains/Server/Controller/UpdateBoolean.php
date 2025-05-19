<?php declare(strict_types=1);

namespace App\Domains\Server\Controller;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class UpdateBoolean extends ControllerAbstract
{
    /**
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function __invoke(int $id): JsonResponse|RedirectResponse
    {
        $this->row($id);

        return $this->request->wantsJson()
            ? $this->responseJson()
            : $this->responseRedirect();
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    protected function responseJson(): JsonResponse
    {
        return $this->json($this->factory()->fractal('simple', $this->action()->updateBoolean()));
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function responseRedirect(): RedirectResponse
    {
        $this->actionCallClosure($this->action()->updateBoolean(...));

        return redirect()->back();
    }
}
