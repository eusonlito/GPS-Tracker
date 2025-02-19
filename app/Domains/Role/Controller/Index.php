<?php declare(strict_types=1);

namespace App\Domains\Role\Controller;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use App\Domains\Role\Model\Role as Model;
use App\Domains\Role\Model\Collection\Role as Collection;
use App\Domains\Role\Service\Controller\Index as ControllerService;

class Index extends ControllerAbstract
{
    /**
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function __invoke(): Response|JsonResponse
    {
        if ($this->request->wantsJson()) {
            return $this->responseJson();
        }

        $this->meta('title', __('role-index.meta-title'));

        return $this->page('role.index', $this->data());
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
        return $this->json($this->factory()->fractal('simple', $this->responseJsonList()));
    }

    /**
     * @return \App\Domains\Role\Model\Collection\Role
     */
    protected function responseJsonList(): Collection
    {
        return Model::query()
            ->byUserId($this->auth->id)
            ->enabled()
            ->get();
    }
}
