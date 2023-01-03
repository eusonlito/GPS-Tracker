<?php declare(strict_types=1);

namespace App\Domains\Trip\Controller;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use App\Domains\Trip\Model\Collection\Trip as Collection;
use App\Domains\Trip\Model\Trip as Model;

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

        $this->meta('title', $this->row->name);

        return $this->page('trip.update-merge', [
            'list' => $this->list(),
        ]);
    }

    /**
     * @return \App\Domains\Trip\Model\Collection\Trip
     */
    protected function list(): Collection
    {
        return Model::query()
            ->selectSimple()
            ->byUserId($this->auth->id)
            ->list()
            ->get();
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
