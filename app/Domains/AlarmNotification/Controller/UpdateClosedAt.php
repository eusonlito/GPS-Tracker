<?php declare(strict_types=1);

namespace App\Domains\AlarmNotification\Controller;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class UpdateClosedAt extends ControllerAbstract
{
    /**
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function __invoke(int $id): JsonResponse|RedirectResponse
    {
        $this->row($id);

        $this->actionCall('updateClosedAt');

        if ($this->request->wantsJson()) {
            return $this->json($this->factory()->fractal('simple', $this->row));
        }

        return redirect()->back();
    }

    /**
     * @return void
     */
    protected function updateClosedAt(): void
    {
        $this->factory()->action()->updateClosedAt();
    }
}
