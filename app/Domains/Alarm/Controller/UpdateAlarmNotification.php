<?php declare(strict_types=1);

namespace App\Domains\Alarm\Controller;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;

class UpdateAlarmNotification extends ControllerAbstract
{
    /**
     * @param int $id
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function __invoke(int $id): Response|RedirectResponse
    {
        $this->row($id);

        $this->meta('title', $this->row->name);

        return $this->page('alarm.update-alarm-notification', [
            'row' => $this->row,
            'notifications' => $this->notifications(),
        ]);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    protected function notifications(): Collection
    {
        return $this->row->notifications()
            ->withVehicle()
            ->withPosition()
            ->withTrip()
            ->list()
            ->get();
    }
}
