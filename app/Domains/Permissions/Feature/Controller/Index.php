<?php declare(strict_types=1);

namespace App\Domains\Permissions\Feature\Controller;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use App\Domains\Permissions\Feature\Model\Feature as Model;
use App\Domains\Permissions\Feature\Model\Collection\Feature as Collection;
use App\Domains\Permissions\Feature\Service\Controller\Index as ControllerService;

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

        $this->meta('title', __('permissions-feature-index.meta-title'));

        return $this->page('permissions.feature.index', $this->data());
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
     * @return \App\Domains\Permissions\Feature\Model\Collection\Feature
     */

    protected function responseJsonList(): Collection
    {
        return new Collection(
            Model::query()
                ->byUserId($this->auth->id)
                ->enabled()
                ->get()
            // ->all()
        );
    }

}
