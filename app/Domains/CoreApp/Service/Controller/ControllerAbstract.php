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
     * @var bool
     */
    protected bool $userEmpty = false;

    /**
     * @var bool
     */
    protected bool $vehicleEmpty = false;

    /**
     * @var bool
     */
    protected bool $deviceEmpty = false;

    /**
     * @param string $column
     * @param bool $empty
     *
     * @return int|string|null
     */
    protected function filtersId(string $column, bool $empty): int|string|null
    {
        if (is_null($id = $this->filtersIdByRequest($column, $empty))) {
            if (is_null($id = $this->filtersIdByUserPreference($column, $empty))) {
                $id = $this->filtersIdByMethod($column);
            }
        }

        if (is_null($id) === false) {
            return $this->auth->preference($column, $id);
        }

        return $id;
    }

    /**
     * @param string $column
     *
     * @return int|string|null
     */
    protected function filtersIdByRequest(string $column, bool $empty): int|string|null
    {
        if ($id = $this->request->input($column)) {
            return $id;
        }

        if ($id === null) {
            return null;
        }

        if ($empty) {
            return $id;
        }

        $this->request->input([$column => null]);

        return null;
    }

    /**
     * @param string $column
     *
     * @return int|string|null
     */
    protected function filtersIdByUserPreference(string $column, bool $empty): int|string|null
    {
        if ($id = $this->auth->preference($column)) {
            return $id;
        }

        if ($empty) {
            return $id;
        }

        return null;
    }

    /**
     * @param string $column
     *
     * @return int|string|null
     */
    protected function filtersIdByMethod(string $column): int|string|null
    {
        $method = preg_replace('/_id$/', '', $column);

        return $this->$method()?->id;
    }

    /**
     * @return void
     */
    protected function filtersUserId(): void
    {
        $this->request->merge(['user_id' => $this->filtersId('user_id', $this->userEmpty)]);
    }

    /**
     * @return void
     */
    protected function filtersVehicleId(): void
    {
        $this->request->merge(['vehicle_id' => $this->filtersId('vehicle_id', $this->vehicleEmpty)]);
    }

    /**
     * @return void
     */
    protected function filtersDeviceId(): void
    {
        $this->request->merge(['device_id' => $this->filtersId('device_id', $this->deviceEmpty)]);
    }

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
        return $this->cache(
            fn () => DeviceModel::query()
                ->whenUserId($this->user()?->id)
                ->whenVehicleId($this->vehicle()?->id)
                ->listSimple()
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
     * @return ?\App\Domains\Device\Model\Device
     */
    protected function device(): ?DeviceModel
    {
        return $this->cache(function () {
            $device_id = $this->request->input('device_id');

            if ($this->deviceEmpty && ($device_id === '')) {
                return;
            }

            $devices = $this->devices();

            if ($device_id === null) {
                return $devices->first();
            }

            return $devices->firstWhere('id', $device_id)
                ?: $devices->first();
        });
    }

    /** @return bool
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
     * @return ?\App\Domains\User\Model\User
     */
    protected function user(): ?UserModel
    {
        return $this->cache(function () {
            if ($this->auth->managerMode() === false) {
                return $this->auth;
            }

            if (isset($this->row->user_id)) {
                return $this->users()->firstWhere('id', $this->row->user_id);
            }

            $user_id = $this->request->input('user_id');

            if ($this->userEmpty && ($user_id === '')) {
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
     * @return ?\App\Domains\Vehicle\Model\Vehicle
     */
    protected function vehicle(): ?VehicleModel
    {
        return $this->cache(function () {
            $vehicle_id = $this->request->input('vehicle_id');

            if ($this->vehicleEmpty && ($vehicle_id === '')) {
                return;
            }

            $vehicles = $this->vehicles();

            if ($vehicle_id === null) {
                return $vehicles->first();
            }

            return $vehicles->firstWhere('id', $vehicle_id)
                ?: $vehicles->first();
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
