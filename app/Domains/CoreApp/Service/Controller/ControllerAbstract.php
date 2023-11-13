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
     * @return array
     */
    protected function dataCore(): array
    {
        return [
            'users' => $this->users(),
            'users_multiple' => $this->usersMultiple(),
            'user' => $this->user(),
            'user_empty' => $this->userEmpty(),
        ];
    }

    /**
     * @return \App\Domains\Device\Model\Collection\Device
     */
    protected function devices(): DeviceCollection
    {
        return $this->cache(function () {
            return DeviceModel::query()
                ->whenUserId($this->user()?->id)
                ->whenVehicleId($this->vehicle()?->id)
                ->listSimple()
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
     * @param bool $empty = true
     *
     * @return ?\App\Domains\Device\Model\Device
     */
    protected function device(bool $empty = true): ?DeviceModel
    {
        return $this->cache(function () use ($empty) {
            $device_id = $this->request->input('device_id');

            if ($device_id === '') {
                return;
            }

            if ($empty && ($device_id === null)) {
                return $this->devices()->first();
            }

            return $this->devices()->firstWhere('id', $device_id)
                ?: $this->devices()->first();
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
            if ($this->auth->managerMode() === false) {
                return new UserCollection();
            }

            return UserModel::query()
                ->listSimple()
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
     * @param bool $empty = true
     *
     * @return ?\App\Domains\User\Model\User
     */
    protected function user(bool $empty = true): ?UserModel
    {
        return $this->cache(function () use ($empty) {
            if ($this->auth->managerMode() === false) {
                return $this->auth;
            }

            if (isset($this->row->user_id)) {
                return $this->users()->firstWhere('id', $this->row->user_id);
            }

            $user_id = $this->request->input('user_id');

            if ($empty && ($user_id === '')) {
                return;
            }

            if ($user_id === null) {
                return $this->auth;
            }

            return $this->users()->firstWhere('id', $user_id)
                ?: $this->auth;
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
                ->listSimple()
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
     * @param bool $empty = true
     *
     * @return ?\App\Domains\Vehicle\Model\Vehicle
     */
    protected function vehicle(bool $empty = true): ?VehicleModel
    {
        return $this->cache(function () use ($empty) {
            $vehicle_id = $this->request->input('vehicle_id');

            if ($empty && ($vehicle_id === '')) {
                return;
            }

            if ($vehicle_id === null) {
                return $this->vehicles()->first();
            }

            return $this->vehicles()->firstWhere('id', $vehicle_id)
                ?: $this->vehicles()->first();
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
