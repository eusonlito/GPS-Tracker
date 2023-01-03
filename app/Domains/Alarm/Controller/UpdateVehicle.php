<?php declare(strict_types=1);

namespace App\Domains\Alarm\Controller;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use App\Domains\Vehicle\Model\Collection\Vehicle as VehicleCollection;
use App\Domains\Vehicle\Model\Vehicle as VehicleModel;

class UpdateVehicle extends ControllerAbstract
{
    /**
     * @param int $id
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function __invoke(int $id): Response|RedirectResponse
    {
        $this->row($id);

        if ($response = $this->actionPost('updateVehicle')) {
            return $response;
        }

        $this->meta('title', $this->row->name);

        return $this->page('alarm.update-vehicle', [
            'row' => $this->row,
            'vehicles' => $this->vehicles(),
        ]);
    }

    /**
     * @return \App\Domains\Vehicle\Model\Collection\Vehicle
     */
    protected function vehicles(): VehicleCollection
    {
        return VehicleModel::query()
            ->list()
            ->withAlarmPivot($this->row->id)
            ->get()
            ->sortByDesc('alarmPivot');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function updateVehicle(): RedirectResponse
    {
        $this->action()->updateVehicle();

        $this->sessionMessage('success', __('alarm-update-vehicle.success'));

        return redirect()->route('alarm.update.vehicle', $this->row->id);
    }
}
