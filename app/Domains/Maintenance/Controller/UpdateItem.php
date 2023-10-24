<?php declare(strict_types=1);

namespace App\Domains\Maintenance\Controller;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use App\Domains\Maintenance\Service\Controller\UpdateItem as ControllerService;

class UpdateItem extends ControllerAbstract
{
    /**
     * @param int $id
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function __invoke(int $id): Response|RedirectResponse|JsonResponse
    {
        $this->row($id);

        if ($response = $this->actionPost('updateItem')) {
            return $response;
        }

        $this->requestMergeWithRow();

        $this->meta('title', __('maintenance-update-item.meta-title', ['title' => $this->row->name]));

        return $this->page('maintenance.update-item', $this->data());
    }

    /**
     * @return array
     */
    protected function data(): array
    {
        return ControllerService::new($this->request, $this->auth, $this->row)->data();
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function updateItem(): RedirectResponse
    {
        $this->action()->updateItem();

        $this->sessionMessage('success', __('maintenance-update-item.success'));

        return redirect()->route('maintenance.update.item', $this->row->id);
    }
}
