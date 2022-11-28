<?php declare(strict_types=1);

namespace App\Domains\AlarmNotification\Controller;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class UpdateSentAt extends ControllerAbstract
{
    /**
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function __invoke(int $id): JsonResponse|RedirectResponse
    {
        $this->row($id);

        $this->actionCall('updateSentAt');

        if ($this->request->wantsJson()) {
            return $this->json($this->factory()->fractal('simple', $this->row));
        }

        return redirect()->back();
    }

    /**
     * @return void
     */
    protected function updateSentAt(): void
    {
        $this->factory()->action()->updateSentAt();
    }
}
