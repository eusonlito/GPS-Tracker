<?php declare(strict_types=1);

namespace App\Domains\Trip\Controller;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use App\Domains\Trip\Service\Controller\UpdateStat as ControllerService;

class UpdateStat extends UpdateAbstract
{
    /**
     * @param int $id
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function __invoke(int $id): Response|RedirectResponse
    {
        $this->load($id);

        if (empty($this->row->stats)) {
            $this->actionCall('updateStats');
        }

        $this->meta('title', __('trip-update-stat.meta-title', ['title' => $this->row->name]));

        return $this->page('trip.update-stat', $this->data());
    }

    /**
     * @return array
     */
    protected function data(): array
    {
        return ControllerService::new($this->request, $this->auth, $this->row)->data();
    }

    /**
     * @return void
     */
    protected function updateStats(): void
    {
        $this->factory()->action()->updateStats();
    }
}
