<?php declare(strict_types=1);

namespace App\Domains\Trip\Controller;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use App\Domains\Alarm\Model\Alarm as AlarmModel;
use App\Domains\AlarmNotification\Model\AlarmNotification as AlarmNotificationModel;

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

        $this->meta('title', $this->row->name);

        return $this->page('trip.update-stat', [
            'stats' => $this->row->stats,
        ]);
    }
}
