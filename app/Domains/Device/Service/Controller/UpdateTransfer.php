<?php declare(strict_types=1);

namespace App\Domains\Device\Service\Controller;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use App\Domains\Device\Model\Device as Model;
use App\Domains\Device\Model\Collection\Device as Collection;
use App\Domains\Trip\Model\Trip as TripModel;
use App\Domains\User\Model\User as UserModel;
use App\Domains\User\Model\Collection\User as UserCollection;
use App\Domains\Vehicle\Model\Vehicle as VehicleModel;
use App\Domains\Vehicle\Model\Collection\Vehicle as VehicleCollection;

class UpdateTransfer extends ControllerAbstract
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Contracts\Auth\Authenticatable $auth
     * @param \App\Domains\Device\Model\Device $row
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
            'devices' => $this->devices(),
            'users' => $this->users(),
            'vehicles' => $this->vehicles(),
            'trips' => $this->trips(),
        ];
    }

    /**
     * @return \App\Domains\Device\Model\Collection\Device
     */
    protected function devices(): Collection
    {
        return Model::query()
            ->byUserId($this->row->user_id)
            ->byIdNot($this->row->id)
            ->list()
            ->get();
    }

    /**
     * @return \App\Domains\User\Model\Collection\User
     */
    protected function users(): UserCollection
    {
        return UserModel::query()
            ->byIdNot($this->row->user_id)
            ->list()
            ->get();
    }

    /**
     * @return \App\Domains\Vehicle\Model\Collection\Vehicle
     */
    protected function vehicles(): VehicleCollection
    {
        return VehicleModel::query()
            ->byUserId($this->row->user_id)
            ->list()
            ->get();
    }

    /**
     * @return int
     */
    protected function trips(): int
    {
        return TripModel::query()
            ->byDeviceId($this->row->id)
            ->count();
    }
}
