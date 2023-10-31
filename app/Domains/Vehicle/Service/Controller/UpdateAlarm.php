<?php declare(strict_types=1);

namespace App\Domains\Vehicle\Service\Controller;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use App\Domains\Alarm\Model\Alarm as AlarmModel;
use App\Domains\Alarm\Model\Collection\Alarm as AlarmCollection;
use App\Domains\Vehicle\Model\Vehicle as Model;

class UpdateAlarm extends ControllerAbstract
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Contracts\Auth\Authenticatable $auth
     * @param \App\Domains\Vehicle\Model\Vehicle $row
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
            'alarms' => $this->alarms(),
        ];
    }

    /**
     * @return \App\Domains\Alarm\Model\Collection\Alarm
     */
    protected function alarms(): AlarmCollection
    {
        return $this->cache(
            fn () => AlarmModel::query()
                ->byUserId($this->user()->id)
                ->withVehiclePivot($this->row->id)
                ->list()
                ->get()
                ->sortByDesc('vehiclePivot')
        );
    }
}
