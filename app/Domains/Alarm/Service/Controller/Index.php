<?php declare(strict_types=1);

namespace App\Domains\Alarm\Service\Controller;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use App\Domains\Alarm\Model\Collection\Alarm as Collection;
use App\Domains\Alarm\Model\Alarm as Model;

class Index extends ControllerAbstract
{
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
        return $this->dataCore() + [
            'vehicles' => $this->vehicles(),
            'vehicles_multiple' => $this->vehiclesMultiple(),
            'vehicle' => $this->vehicle(),
            'vehicle_empty' => $this->vehicleEmpty(),
            'list' => $this->list(),
        ];
    }

    /**
     * @return \App\Domains\Alarm\Model\Collection\Alarm
     */
    protected function list(): Collection
    {
        return $this->cache(
            fn () => Model::query()
                ->whenUserId($this->user()?->id)
                ->whenVehicleId($this->vehicle()?->id)
                ->withUser()
                ->withVehiclesCount()
                ->withNotificationsCount()
                ->withNotificationsPendingCount()
                ->list()
                ->get()
        );
    }
}
