<?php declare(strict_types=1);

namespace App\Domains\AlarmNotification\Service\Controller;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use App\Domains\AlarmNotification\Model\Collection\AlarmNotification as Collection;
use App\Domains\AlarmNotification\Model\AlarmNotification as Model;

class Index extends ControllerAbstract
{
    /**
     * @const string
     */
    protected const DATE_REGEXP = '/^[0-9]{4}\-[0-9]{2}\-[0-9]{2}$/';

    /**
     * @var bool
     */
    protected bool $userEmpty = true;

    /**
     * @var bool
     */
    protected bool $vehicleEmpty = true;

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
        $this->filtersUserId();
        $this->filtersVehicleId();
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
            'user_empty' => $this->userEmpty(),
            'vehicles' => $this->vehicles(),
            'vehicles_multiple' => $this->vehiclesMultiple(),
            'vehicle' => $this->vehicle(),
            'vehicle_empty' => $this->vehicleEmpty(),
            'list' => $this->list(),
        ];
    }

    /**
     * @return \App\Domains\AlarmNotification\Model\Collection\AlarmNotification
     */
    protected function list(): Collection
    {
        return $this->cache(
            fn () => Model::query()
                ->whenUserId($this->user()?->id)
                ->whenVehicleId($this->vehicle()?->id)
                ->withAlarm()
                ->withPosition()
                ->withTrip()
                ->withUser()
                ->withVehicle()
                ->list()
                ->get()
        );
    }
}
