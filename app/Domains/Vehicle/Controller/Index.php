<?php declare(strict_types=1);

namespace App\Domains\Vehicle\Controller;

use Illuminate\Http\Response;
use App\Domains\Vehicle\Model\Collection\Vehicle as Collection;
use App\Domains\Vehicle\Model\Vehicle as Model;

class Index extends ControllerAbstract
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function __invoke(): Response
    {
        $this->meta('title', __('vehicle-index.meta-title'));

        return $this->page('vehicle.index', [
            'list' => $this->list(),
        ]);
    }

    /**
     * @return \App\Domains\Vehicle\Model\Collection\Vehicle
     */
    protected function list(): Collection
    {
        return Model::query()
            ->byUserId($this->auth->id)
            ->withAlarmsCount()
            ->withAlarmsNotificationsCount()
            ->withAlarmsNotificationsPendingCount()
            ->withTimezone()
            ->list()
            ->get();
    }
}
