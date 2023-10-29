<?php declare(strict_types=1);

namespace App\Domains\Alarm\Service\Controller;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use App\Domains\Device\Model\Device as DeviceModel;
use App\Domains\Alarm\Model\Collection\Alarm as Collection;
use App\Domains\Alarm\Model\Alarm as Model;
use App\Domains\Vehicle\Model\Vehicle as VehicleModel;

class Index extends ControllerAbstract
{
    /**
     * @const string
     */
    protected const DATE_REGEXP = '/^[0-9]{4}\-[0-9]{2}\-[0-9]{2}$/';

    /**
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Contracts\Auth\Authenticatable $auth
     *
     * @return self
     */
    public function __construct(protected Request $request, protected Authenticatable $auth)
    {
        $this->filters();
    }

    /**
     * @return void
     */
    protected function filters(): void
    {
        $this->request->merge([
            'user_id' => $this->auth->preference('user_id', $this->request->input('user_id')),
            'vehicle_id' => $this->auth->preference('vehicle_id', $this->request->input('vehicle_id')),
            'device_id' => $this->auth->preference('device_id', $this->request->input('device_id')),
        ]);
    }

    /**
     * @return array
     */
    public function data(): array
    {
        return [
            'users' => $this->users(),
            'users_multiple' => $this->usersMultiple(),
            'user' => $this->user(),
            'vehicles' => $this->vehicles(),
            'vehicles_multiple' => $this->vehiclesMultiple(),
            'vehicle' => $this->vehicle(),
            'devices' => $this->devices(),
            'devices_multiple' => $this->devicesMultiple(),
            'device' => $this->device(),
            'list' => $this->list(),
        ];
    }

    /**
     * @return ?\App\Domains\Vehicle\Model\Vehicle
     */
    protected function vehicle(): ?VehicleModel
    {
        return $this->cache(
            fn () => $this->vehicles()->firstWhere('id', $this->request->input('vehicle_id'))
                ?: $this->vehicles()->last()
        );
    }

    /**
     * @return ?\App\Domains\Device\Model\Device
     */
    protected function device(): ?DeviceModel
    {
        return $this->cache(
            fn () => $this->devices()->firstWhere('id', $this->request->input('device_id'))
        );
    }

    /**
     * @return \App\Domains\Alarm\Model\Collection\Alarm
     */
    protected function list(): Collection
    {
        return $this->cache(
            fn () => Model::query()
                ->byUserId($this->user()->id)
                ->withVehiclesCount()
                ->withNotificationsCount()
                ->withNotificationsPendingCount()
                ->list()
                ->get()
        );
    }
}
