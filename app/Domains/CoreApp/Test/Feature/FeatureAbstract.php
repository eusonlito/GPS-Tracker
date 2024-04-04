<?php declare(strict_types=1);

namespace App\Domains\CoreApp\Test\Feature;

use App\Domains\Core\Model\ModelAbstract;
use App\Domains\Core\Test\Feature\FeatureAbstract as FeatureAbstractCore;
use App\Domains\Device\Model\Device as DeviceModel;
use App\Domains\User\Model\User as UserModel;
use App\Domains\Vehicle\Model\Vehicle as VehicleModel;

abstract class FeatureAbstract extends FeatureAbstractCore
{
    /**
     * @return \App\Domains\User\Model\User
     */
    protected function createUser(): UserModel
    {
        return $this->factoryCreate(UserModel::class);
    }

    /**
     * @param ?\App\Domains\User\Model\User $user
     *
     * @return array
     */
    protected function createUserRow(?UserModel $user = null): array
    {
        $user ??= $this->createUser();

        if ($this->getModelClass() === UserModel::class) {
            return [$user, $user];
        }

        $row = $this->factoryCreate(data: array_filter(['user_id' => $user->id]));

        $this->assertEquals($user->id, $row->user_id, '$user->id, $row->user_id');

        return [$user, $row];
    }

    /**
     * @param ?\App\Domains\User\Model\User $user
     *
     * @return \App\Domains\Vehicle\Model\Vehicle
     */
    protected function createVehicle(?UserModel $user = null): VehicleModel
    {
        return $this->factoryCreate(VehicleModel::class, array_filter([
            'user_id' => $user?->id,
        ]));
    }

    /**
     * @param ?\App\Domains\Vehicle\Model\Vehicle $vehicle
     *
     * @return \App\Domains\Device\Model\Device
     */
    protected function createDevice(?VehicleModel $vehicle = null): DeviceModel
    {
        return $this->factoryCreate(DeviceModel::class, array_filter([
            'user_id' => $vehicle?->user_id,
            'vehicle_id' => $vehicle?->id,
        ]));
    }

    /**
     * @param bool $vehicle = true
     * @param bool $device = true
     *
     * @return array
     */
    protected function createUserVehicleDevice(bool $vehicle = true, bool $device = true): array
    {
        $user = $this->createUser();
        $vehicle = $vehicle ? $this->createVehicle($user) : null;
        $device = $device ? $this->createDevice($vehicle) : null;

        if ($vehicle) {
            $this->assertEquals($user->id, $vehicle->user_id, '$user->id, $vehicle->user_id');
        }

        if ($device) {
            $this->assertEquals($user->id, $device->user_id, '$user->id, $device->user_id');
            $this->assertEquals($vehicle->id, $device->vehicle_id, '$vehicle->id, $device->vehicle_id');
        }

        return [$user, $vehicle, $device];
    }

    /**
     * @param bool $vehicle = true
     * @param bool $device = true
     *
     * @return array
     */
    protected function createUserVehicleDeviceRow(bool $vehicle = true, bool $device = true): array
    {
        [$user, $vehicle, $device] = $this->createUserVehicleDevice($vehicle, $device);

        $row = $this->createRowWithUserVehicleDevice($user, $vehicle, $device);

        return [$user, $vehicle, $device, $row];
    }

    /**
     * @param \App\Domains\User\Model\User $user
     * @param bool $vehicle = true
     * @param bool $device = true
     *
     * @return array
     */
    protected function createVehicleDeviceWithUser(UserModel $user, bool $vehicle = true, bool $device = true): array
    {
        $vehicle = $vehicle ? $this->createVehicle($user) : null;
        $device = $device ? $this->createDevice($vehicle) : null;

        return [$vehicle, $device];
    }

    /**
     * @param \App\Domains\User\Model\User $user
     * @param bool $vehicle = true
     * @param bool $device = true
     *
     * @return array
     */
    protected function createVehicleDeviceRowWithUser(UserModel $user, bool $vehicle = true, bool $device = true): array
    {
        $vehicle = $vehicle ? $this->createVehicle($user) : null;
        $device = $device ? $this->createDevice($vehicle) : null;

        $row = $this->createRowWithUserVehicleDevice($user, $vehicle, $device);

        return [$vehicle, $device, $row];
    }

    /**
     * @param \App\Domains\User\Model\User $user
     * @param ?\App\Domains\Vehicle\Model\Vehicle $vehicle = null
     * @param ?\App\Domains\Device\Model\Device $device = null
     *
     * @return \App\Domains\Core\Model\ModelAbstract
     */
    protected function createRowWithUserVehicleDevice(UserModel $user, ?VehicleModel $vehicle = null, ?DeviceModel $device = null): ModelAbstract
    {
        $row = $this->factoryCreate(data: array_filter([
            'user_id' => $user->id,
            'vehicle_id' => $vehicle?->id,
            'device_id' => $device?->id,
        ]));

        $this->assertEquals($user->id, $row->user_id, '$user->id, $row->user_id');

        if ($vehicle) {
            $this->assertEquals($vehicle->id, $row->vehicle_id, '$vehicle->id, $row->vehicle_id');
        }

        if ($device) {
            $this->assertEquals($device->id, $row->device_id, '$device->id, $row->device_id');
        }

        return $row;
    }

    /**
     * @param \App\Domains\User\Model\User $user
     * @param ?\App\Domains\Vehicle\Model\Vehicle $vehicle = null
     * @param ?\App\Domains\Device\Model\Device $device = null
     *
     * @return array
     */
    protected function dataWithUserVehicleDeviceMake(UserModel $user, ?VehicleModel $vehicle = null, ?DeviceModel $device = null): array
    {
        $data = ['user_id' => $user->id];

        if ($vehicle) {
            $data['vehicle_id'] = $vehicle->id;
        }

        if ($device) {
            $data['device_id'] = $device->id;
        }

        return $data + $this->factoryMake()->toArray();
    }
}
