<?php declare(strict_types=1);

namespace App\Domains\Alarm\Service\Controller;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use App\Domains\Alarm\Model\Alarm as Model;
use App\Domains\Vehicle\Model\Collection\Vehicle as VehicleCollection;
use App\Domains\Vehicle\Model\Vehicle as VehicleModel;

class UpdateVehicle extends ControllerAbstract
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Contracts\Auth\Authenticatable $auth
     * @param \App\Domains\Alarm\Model\Alarm $row
     *
     * @return self
     */
    public function __construct(protected Request $request, protected Authenticatable $auth, protected Model $row)
    {
    }

    /**
     * @return array
     */
    public function data(): array
    {
        return [
            'row' => $this->row,
            'vehicles' => $this->vehicles(),
        ];
    }

    /**
     * @return \App\Domains\Vehicle\Model\Collection\Vehicle
     */
    protected function vehicles(): VehicleCollection
    {
        return VehicleModel::query()
            ->byUserId($this->user()->id)
            ->list()
            ->withAlarmPivot($this->row->id)
            ->get()
            ->sortByDesc('alarmPivot');
    }
}
