<?php declare(strict_types=1);

namespace App\Domains\City\Controller;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use App\Domains\City\Service\Controller\UpdateMerge as ControllerService;

class UpdateMerge extends ControllerAbstract
{
    /**
     * @param int $id
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function __invoke(int $id): Response|RedirectResponse
    {
        $this->row($id);

        if ($response = $this->actionPost('updateMerge')) {
            return $response;
        }

        $this->meta('title', __('city-update-merge.meta-title', ['title' => $this->row->name]));

        return $this->page('city.update-merge', $this->data());
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

        $this->sessionMessage('success', __('city-update-merge.success'));

        return redirect()->route('city.update.merge', $this->row->id);
    }
}
