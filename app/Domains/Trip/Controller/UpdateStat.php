<?php declare(strict_types=1);

namespace App\Domains\Trip\Controller;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

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

        $this->meta('title', $this->row->name);

        return $this->page('trip.update-stat', [
            'stats' => $this->row->stats,
        ]);
    }

    /**
     * @return void
     */
    protected function updateStats(): void
    {
        $this->factory()->action()->updateStats();
    }
}
