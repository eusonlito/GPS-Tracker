<?php declare(strict_types=1);

namespace App\Domains\Trip\Controller;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use App\Domains\Trip\Service\Controller\UpdateMerge as ControllerService;

class UpdateMerge extends UpdateAbstract
{
    /**
     * @param int $id
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function __invoke(int $id): Response|RedirectResponse
    {
        $this->load($id);

        if ($response = $this->actionPost('updateMerge')) {
            return $response;
        }

        $this->meta('title', __('trip-update-merge.meta-title', ['title' => $this->row->name]));

        return $this->page('trip.update-merge', $this->data());
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
    protected function updateMerge(): RedirectResponse
    {
        $this->action()->updateMerge();

        $this->sessionMessage('success', __('trip-update-merge.success'));

        return redirect()->route('trip.update.map', $this->row->id);
    }
}
