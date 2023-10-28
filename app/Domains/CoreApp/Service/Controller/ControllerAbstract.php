<?php declare(strict_types=1);

namespace App\Domains\CoreApp\Service\Controller;

use App\Domains\Core\Service\Controller\ControllerAbstract as ControllerAbstractCore;
use App\Domains\Device\Model\Collection\Device as DeviceCollection;
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
        if ($this->vehicle() === null) {
            return new DeviceCollection();
        }

        return $this->cache(
            fn () => $this->vehicle()
                ->devices()
                ->simple()
                ->get()
        );
    }

    /**
     * @return bool
     */
    protected function devicesMultiple(): bool
    {
        return $this->devices()->count() > 1;
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
     * @return \App\Domains\User\Model\User
     */
    protected function user(): UserModel
    {
        return $this->cache(function () {
            if (empty($this->auth->admin)) {
                return $this->auth;
            }

            if (empty($user_id = $this->request->integer('user_id'))) {
                return $this->auth;
            }

            return $this->users()->firstWhere('id', $user_id)
                ?: $this->auth;
        });
    }

    /**
     * @return \App\Domains\Vehicle\Model\Collection\Vehicle
     */
    protected function vehicles(): VehicleCollection
    {
        return $this->cache(
            fn () => VehicleModel::query()
                ->byUserId($this->user()->id)
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
}
