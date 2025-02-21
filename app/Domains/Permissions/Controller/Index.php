<?php declare(strict_types=1);

namespace App\Domains\Permissions\Controller;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use App\Domains\Permissions\Model\Permission as Model;
use App\Domains\Permissions\Model\Collection\Permission as Collection;
use App\Domains\Permissions\Feature\Service\Controller\Index as ControllerService;

class Index extends ControllerAbstract
{
    public function __invoke(): Response|JsonResponse
    {
        if ($this->request->wantsJson()) {
            return $this->responseJson();
        }

        $this->meta('title', __('permissions-index.meta-title'));

        return $this->page('permissions.index', $this->data());
    }

    protected function data(): array
    {
        $data = ControllerService::new($this->request, $this->auth)->data();

        // Nếu chưa có 'permissions', thêm vào
        if (!array_key_exists('permissions', $data)) {
            $data['permissions'] = Model::query()
                ->with(['role', 'action', 'entity', 'scope']) // Load quan hệ nếu cần
                ->get();
        }

        return $data;
    }

    protected function responseJson(): JsonResponse
    {
        return $this->json($this->factory()->fractal('simple', $this->responseJsonList()));
    }
    protected function responseJsonList(): Collection
    {
        return new Collection(
            Model::query()
                ->with(['role', 'action', 'entity', 'scope'])
                ->get()
        );
    }

}
