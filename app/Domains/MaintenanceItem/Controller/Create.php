<?php declare(strict_types=1);

namespace App\Domains\MaintenanceItem\Controller;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use App\Domains\MaintenanceItem\Service\Controller\Create as ControllerService;

class Create extends ControllerAbstract
{
    /**
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function __invoke(): Response|RedirectResponse|JsonResponse
    {
        if ($this->request->wantsJson()) {
            return $this->responseJson();
        }

        if ($response = $this->actionPost('create')) {
            return $response;
        }

        $this->meta('title', __('maintenance-item-create.meta-title'));

        return $this->page('maintenance-item.create', $this->data());
    }

    /**
     * @return array
     */
    protected function data(): array
    {
        return ControllerService::new($this->request, $this->auth)->data();
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    protected function responseJson(): JsonResponse
    {
        return $this->json($this->factory()->fractal('simple', $this->action()->create()));
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function create(): RedirectResponse
    {
        $this->row = $this->action()->create();

        $this->sessionMessage('success', __('maintenance-item-create.success'));

        return redirect()->route('maintenance-item.update', $this->row->id);
    }
}
