<?php declare(strict_types=1);

namespace App\Domains\CoreApp\Service\Controller;

use App\Domains\Core\Service\Controller\ControllerAbstract as ControllerAbstractCore;
use App\Domains\Device\Model\Collection\Device as DeviceCollection;
use App\Domains\Device\Model\Device as DeviceModel;
use App\Domains\User\Model\Collection\User as UserCollection;
use App\Domains\User\Model\User as UserModel;
use App\Domains\Vehicle\Model\Collection\Vehicle as VehicleCollection;
use App\Domains\Vehicle\Model\Vehicle as VehicleModel;

abstract class ControllerAbstract extends ControllerAbstractCore
{
    /**
     * @return \App\Domains\Device\Model\Collection\Device
     */
    protected function devices(): DeviceCollection
    {
        return $this->cache(function () {
            return DeviceModel::query()
                ->whenUserId($this->user()?->id)
                ->whenVehicleId($this->vehicle()?->id)
                ->simple()
                ->get();
        });
    }

    /**
     * @return bool
     */
    protected function devicesMultiple(): bool
    {
        return $this->devices()->count() > 1;
    }

    /**
     * @return ?\App\Domains\Device\Model\Device
     */
    protected function device(): ?DeviceModel
    {
        return $this->cache(function () {
            $device_id = $this->request->input('device_id');

            if ($device_id === '') {
                return;
            }

            if ($device_id === null) {
                return $this->devices()->first();
            }

            return $this->devices()->firstWhere('id', $device_id);
        });
    }

    /**
     * @return bool
     */
    protected function deviceEmpty(): bool
    {
        return $this->cache(fn () => empty($this->device()));
    }

    /**
     * @return \App\Domains\User\Model\Collection\User
     */
    protected function users(): UserCollection
    {
        return $this->cache(function () {
            if (empty($this->auth->admin)) {
                return new UserCollection();
            }

            return UserModel::query()
                ->simple()
                ->get();
        });
    }

    /**
     * @return bool
     */
    protected function usersMultiple(): bool
    {
        return $this->users()->count() > 1;
    }

    /**
     * @return ?\App\Domains\User\Model\User
     */
    protected function user(): ?UserModel
    {
        return $this->cache(function () {
            if (empty($this->auth->admin)) {
                return $this->auth;
            }

            $user_id = $this->request->input('user_id');

            if ($user_id === '') {
                return;
            }

            if ($user_id === null) {
                return $this->auth;
            }

            return $this->users()->firstWhere('id', $user_id);
        });
    }

    /**
     * @return bool
     */
    protected function userEmpty(): bool
    {
        return $this->cache(fn () => empty($this->user()));
    }

    /**
     * @return \App\Domains\Vehicle\Model\Collection\Vehicle
     */
    protected function vehicles(): VehicleCollection
    {
        return $this->cache(
            fn () => VehicleModel::query()
                ->whenUserId($this->user()?->id)
                ->simple()
                ->get()
        );
    }

    /**
     * @return bool
     */
    protected function vehiclesMultiple(): bool
    {
        return $this->vehicles()->count() > 1;
    }

    /**
     * @return ?\App\Domains\Vehicle\Model\Vehicle
     */
    protected function vehicle(): ?VehicleModel
    {
        return $this->cache(function () {
            $vehicle_id = $this->request->input('vehicle_id');

            if ($vehicle_id === '') {
                return;
            }

            if ($vehicle_id === null) {
                return $this->vehicle()->first();
            }

            return $this->vehicles()->firstWhere('id', $vehicle_id);
        });
    }

    /**
     * @return bool
     */
    protected function vehicleEmpty(): bool
    {
        return $this->cache(fn () => empty($this->vehicle()));
    }
}
