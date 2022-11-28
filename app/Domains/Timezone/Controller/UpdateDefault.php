<?php declare(strict_types=1);

namespace App\Domains\Timezone\Controller;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use App\Domains\Timezone\Model\Timezone as Model;

class UpdateDefault extends ControllerAbstract
{
    /**
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function __invoke(int $id): JsonResponse|RedirectResponse
    {
        $this->row($id);

        $this->actionCall('updateDefault');

        if ($this->request->wantsJson()) {
            return $this->responseJson();
        }

        return redirect()->back();
    }

    /**
     * @return \App\Domains\Timezone\Model\Timezone
     */
    protected function updateDefault(): Model
    {
        return $this->action()->updateDefault();
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    protected function responseJson(): JsonResponse
    {
        return $this->json($this->factory()->fractal('simple', $this->row));
    }
}
