<?php declare(strict_types=1);

namespace App\Domains\CoreApp\Test\Feature;

use Illuminate\Testing\TestResponse;
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
        $user = $user ?? $this->createUser();

        $row = $this->factoryCreate(data: array_filter([
            'user_id' => $user->id,
        ]));

        $this->assertEquals($row->user_id, $user->id);

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
            'user_id' => $user?->id
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
            'vehicle_id' => $vehicle?->id
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
            $this->assertEquals($vehicle->user_id, $user->id);
        }

        if ($device) {
            $this->assertEquals($device->user_id, $user->id);
            $this->assertEquals($device->vehicle_id, $vehicle->id);
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

        $this->assertEquals($row->user_id, $user->id);

        if ($vehicle) {
            $this->assertEquals($row->vehicle_id, $vehicle->id);
        }

        if ($device) {
            $this->assertEquals($row->device_id, $device->id);
        }

        return $row;
    }

    /**
     * @return void
     */
    public function getGuestUnauthorizedFail(): void
    {
        $this->get($this->routeToController())
            ->assertStatus(302)
            ->assertRedirect(route('user.auth.credentials'));
    }

    /**
     * @return void
     */
    public function postGuestUnauthorizedFail(): void
    {
        $this->post($this->routeToController())
            ->assertStatus(302)
            ->assertRedirect(route('user.auth.credentials'));
    }

    /**
     * @return void
     */
    public function getGuestNotAllowedFail(): void
    {
        $this->get($this->routeToController())
            ->assertStatus(405);
    }

    /**
     * @return void
     */
    public function postGuestNotAllowedFail(): void
    {
        $this->post($this->routeToController())
            ->assertStatus(405);
    }

    /**
     * @return void
     */
    public function getAuthNotAllowedFail(): void
    {
        $this->authUser();

        $this->get($this->routeToController())
            ->assertStatus(405);
    }

    /**
     * @return void
     */
    public function postAuthNotAllowedFail(): void
    {
        $this->authUser();

        $this->post($this->routeToController())
            ->assertStatus(405);
    }

    /**
     * @return void
     */
    public function getAuthUnauthorizedFail(): void
    {
        $this->authUser();

        $this->get($this->routeToController())
            ->assertStatus(404);
    }

    /**
     * @return void
     */
    public function postAuthUnauthorizedFail(): void
    {
        $this->authUser();

        $this->post($this->routeToController())
            ->assertStatus(404);
    }

    /**
     * @return void
     */
    public function getAuthSuccess(): void
    {
        $this->authUser();

        $this->get($this->routeToController())
            ->assertStatus(200);

        $this->factoryCreate();

        $this->get($this->routeToController())
            ->assertStatus(200);
    }

    /**
     * @return void
     */
    public function postAuthSuccess(): void
    {
        $this->authUser();

        $this->post($this->routeToController())
            ->assertStatus(200);

        $this->factoryCreate();

        $this->post($this->routeToController())
            ->assertStatus(200);
    }

    /**
     * @return void
     */
    public function getAuthInvalidFail(): void
    {
        $this->authUser();

        $this->get($this->routeFactoryCreateModel(null, 'invalid'))
            ->assertStatus(422);
    }

    /**
     * @return void
     */
    public function postAuthInvalidFail(): void
    {
        $this->authUser();

        $this->post($this->routeFactoryCreateModel(null, 'invalid'))
            ->assertStatus(422);
    }

    /**
     * @return void
     */
    public function getAuthAdminNotAllowedFail(): void
    {
        $this->authUserAdmin();

        $this->get($this->routeToController())
            ->assertStatus(405);
    }

    /**
     * @return void
     */
    public function postAuthAdminNotAllowedFail(): void
    {
        $this->authUserAdmin();

        $this->post($this->routeToController())
            ->assertStatus(405);
    }

    /**
     * @return void
     */
    public function getAuthAdminSuccess(): void
    {
        $this->authUserAdmin();

        $this->get($this->routeToController())
            ->assertStatus(200);

        $this->factoryCreate();

        $this->get($this->routeToController())
            ->assertStatus(200);
    }

    /**
     * @return void
     */
    public function postAuthAdminSuccess(): void
    {
        $this->authUserAdmin();

        $this->post($this->routeToController())
            ->assertStatus(200);

        $this->factoryCreate();

        $this->post($this->routeToController())
            ->assertStatus(200);
    }

    /**
     * @param string $name = 'name'
     *
     * @return void
     */
    public function getAuthListSuccess(string $name = 'name'): void
    {
        $this->authUser();

        $row = $this->factoryCreate();

        $this->get($this->routeToController())
            ->assertStatus(200)
            ->assertSee($row->$name);
    }

    /**
     * @param string $name = 'name'
     * @param bool $vehicle = true
     * @param bool $device = true
     * @param bool $multiple = false
     *
     * @return void
     */
    public function getAuthListOnlyOwnSucess(string $name = 'name', bool $vehicle = true, bool $device = true, bool $multiple = false): void
    {
        $user1 = $this->authUser();
        $user2 = $this->createUser();

        if ($multiple) {
            $this->createVehicleDeviceRowWithUser($user1, $vehicle, $device);
            $this->createVehicleDeviceRowWithUser($user2, $vehicle, $device);
        }

        [$vehicle1, $device1, $row1] = $this->createVehicleDeviceRowWithUser($user1, $vehicle, $device);
        [$vehicle2, $device2, $row2] = $this->createVehicleDeviceRowWithUser($user2, $vehicle, $device);

        $response = $this->get($this->routeToController().'?vehicle_id=&device_id=')
            ->assertStatus(200)
            ->assertSeeText($row1->$name)
            ->assertDontSeeText($row2->$name)
            ->assertDontSeeText($user2->name);

        if ($vehicle) {
            $response->assertSeeText($vehicle1->name);
            $response->assertDontSeeText($vehicle2->name);
        }

        if ($device) {
            $response->assertSeeText($device1->name);
            $response->assertDontSeeText($device2->name);
        }

        $this->auth($user2);

        $response = $this->get($this->routeToController().'?vehicle_id=&device_id=')
            ->assertStatus(200)
            ->assertSeeText($row2->$name)
            ->assertDontSeeText($row1->$name);

        if ($vehicle) {
            $response->assertSeeText($vehicle2->name);
            $response->assertDontSeeText($vehicle1->name);
        }

        if ($device) {
            $response->assertSeeText($device2->name);
            $response->assertDontSeeText($device1->name);
        }
    }

    /**
     * @param string $name = 'name'
     * @param bool $vehicle = true
     * @param bool $device = true
     * @param bool $multiple = false
     *
     * @return \Illuminate\Testing\TestResponse
     */
    public function getAuthListAdminSuccess(string $name = 'name', bool $vehicle = true, bool $device = true, bool $multiple = false): TestResponse
    {
        $user1 = $this->authUserAdmin(true, false);
        $user2 = $this->createUser();

        if ($multiple) {
            $this->createVehicleDeviceRowWithUser($user1, $vehicle, $device);
            $this->createVehicleDeviceRowWithUser($user2, $vehicle, $device);
        }

        [$vehicle1, $device1, $row1] = $this->createVehicleDeviceRowWithUser($user1, $vehicle, $device);
        [$vehicle2, $device2, $row2] = $this->createVehicleDeviceRowWithUser($user2, $vehicle, $device);

        $response = $this->get($this->routeToController().'?user_id=&vehicle_id=&device_id=')
            ->assertStatus(200)
            ->assertSeeText($row1->$name)
            ->assertDontSeeText($row2->$name)
            ->assertDontSeeText($user2->name);

        if ($vehicle) {
            $response->assertSeeText($vehicle1->name);
            $response->assertDontSeeText($vehicle2->name);
        }

        if ($device) {
            $response->assertSeeText($device1->name);
            $response->assertDontSeeText($device2->name);
        }

        return $response;
    }

    /**
     * @param string $name = 'name'
     * @param bool $vehicle = true
     * @param bool $device = true
     * @param bool $multiple = false
     *
     * @return \Illuminate\Testing\TestResponse
     */
    public function getAuthListAdminModeSuccess(string $name = 'name', bool $vehicle = true, bool $device = true, bool $multiple = false): TestResponse
    {
        $user1 = $this->authUserAdmin(true, true);
        $user2 = $this->createUser();

        if ($multiple) {
            $this->createVehicleDeviceRowWithUser($user1, $vehicle, $device);
            $this->createVehicleDeviceRowWithUser($user2, $vehicle, $device);
        }

        [$vehicle1, $device1, $row1] = $this->createVehicleDeviceRowWithUser($user1, $vehicle, $device);
        [$vehicle2, $device2, $row2] = $this->createVehicleDeviceRowWithUser($user2, $vehicle, $device);

        $response = $this->get($this->routeToController().'?user_id=&vehicle_id=&device_id=')
            ->assertStatus(200)
            ->assertSeeText($row1->$name)
            ->assertSeeText($row2->$name)
            ->assertSeeText($user1->name)
            ->assertSeeText($user2->name);

        if ($vehicle) {
            $response->assertSeeText($vehicle1->name);
            $response->assertSeeText($vehicle2->name);
        }

        if ($device) {
            $response->assertSeeText($device1->name);
            $response->assertSeeText($device2->name);
        }

        $response = $this->get($this->routeToController().'?user_id='.$user2->id.'&vehicle_id=&device_id=')
            ->assertStatus(200)
            ->assertDontSeeText($row1->$name)
            ->assertSeeText($row2->$name)
            ->assertSeeText($user1->name)
            ->assertSeeText($user2->name);

        if ($vehicle) {
            $response->assertDontSeeText($vehicle1->name);
            $response->assertSeeText($vehicle2->name);
        }

        if ($device) {
            $response->assertDontSeeText($device1->name);
            $response->assertSeeText($device2->name);
        }

        return $response;
    }

    /**
     * @param ?string $redirect = null
     * @param array $exclude = []
     *
     * @return void
     */
    public function postAuthCreateSuccess(?string $redirect = null, array $exclude = []): void
    {
        $this->authUser();

        $data = $this->factoryMake()->toArray();

        $this->post($this->routeToController(), $data + $this->action())
            ->assertStatus(302)
            ->assertRedirect(route($this->routeCreateToUpdate($redirect), $this->rowLast()->id));

        $this->dataVsRow($data, $this->rowLast(), $exclude);
    }

    /**
     * @param bool $vehicle = true
     * @param bool $device = true
     *
     * @return \Illuminate\Testing\TestResponse
     */
    public function getAuthCreateAdminSuccess(bool $vehicle = true, bool $device = true): TestResponse
    {
        $user1 = $this->authUserAdmin(true, false);

        $this->createVehicleDeviceWithUser($user1, $vehicle, $device);

        [$user2] = $this->createUserVehicleDevice($vehicle, $device);

        return $this->get($this->routeToController())
            ->assertStatus(200)
            ->assertDontSeeText($user2->name);
    }

    /**
     * @param ?string $redirect = null
     * @param bool $vehicle = true
     * @param bool $device = true
     *
     * @return \Illuminate\Testing\TestResponse
     */
    public function postAuthCreateAdminFail(?string $redirect = null, bool $vehicle = true, bool $device = true): TestResponse
    {
        $user1 = $this->authUserAdmin(true, false);

        [$user2, $vehicle2, $device2] = $this->createUserVehicleDevice($vehicle, $device);

        $data = $this->dataWithUserVehicleDeviceMake($user2);

        $response = $this->post($this->routeToController(), $data + $this->action())
            ->assertStatus(302)
            ->assertRedirect(route($this->routeCreateToUpdate($redirect), $this->rowLast()->id));

        $this->assertEquals($this->rowLast()->user_id, $user1->id);

        return $response;
    }

    /**
     * @param ?string $redirect = null
     * @param array $exclude = []
     *
     * @return void
     */
    public function postAuthCreateAdminSuccess(?string $redirect = null, array $exclude = []): void
    {
        $this->authUserAdmin(true, false);

        $data = $this->factoryMake()->toArray();

        $this->post($this->routeToController(), $data + $this->action())
            ->assertStatus(302)
            ->assertRedirect(route($this->routeCreateToUpdate($redirect), $this->rowLast()->id));

        $this->dataVsRow($data, $this->rowLast(), $exclude);
    }

    /**
     * @param bool $vehicle = true
     * @param bool $device = true
     *
     * @return \Illuminate\Testing\TestResponse
     */
    public function getAuthCreateAdminModeSuccess(bool $vehicle = true, bool $device = true): TestResponse
    {
        $user1 = $this->authUserAdmin(true, true);

        [$vehicle1, $device1, $row1] = $this->createVehicleDeviceRowWithUser($user1, $vehicle, $device);
        [$user2, $vehicle2, $device2, $row2] = $this->createUserVehicleDeviceRow($vehicle, $device);

        $response = $this->get($this->routeToController().'?user_id=')
            ->assertStatus(200)
            ->assertSeeText($user1->name)
            ->assertSeeText($user2->name);

        if ($vehicle) {
            $response->assertSeeText($vehicle1->name);
            $response->assertDontSeeText($vehicle2->name);
        }

        if ($device) {
            $response->assertSeeText($device1->name);
            $response->assertDontSeeText($device2->name);
        }

        $response = $this->get($this->routeToController().'?user_id='.$user2->id)
            ->assertStatus(200)
            ->assertSeeText($user1->name)
            ->assertSeeText($user2->name);

        if ($vehicle) {
            $response->assertDontSeeText($vehicle1->name);
            $response->assertSeeText($vehicle2->name);
        }

        if ($device) {
            $response->assertDontSeeText($device1->name);
            $response->assertSeeText($device2->name);
        }

        return $response;
    }

    /**
     * @param bool $vehicle = true
     * @param bool $device = true
     *
     * @return \Illuminate\Testing\TestResponse
     */
    public function postAuthCreateAdminModeFail(bool $vehicle = true, bool $device = true): TestResponse
    {
        $user1 = $this->authUserAdmin(true, true);

        [$vehicle1, $device1] = $this->createVehicleDeviceWithUser($user1, $vehicle, $device);

        $data = $this->dataWithUserVehicleDeviceMake($this->createUser(), $vehicle1, $device1);

        return $this->post($this->routeToController(), $data + $this->action())
            ->assertStatus(422);
    }

    /**
     * @param ?string $redirect = null
     * @param bool $vehicle = true
     * @param bool $device = true
     * @param array $exclude = []
     *
     * @return \Illuminate\Testing\TestResponse
     */
    public function postAuthCreateAdminModeSuccess(?string $redirect = null, bool $vehicle = true, bool $device = true, array $exclude = []): TestResponse
    {
        $user1 = $this->authUserAdmin(true, true);

        [$vehicle1, $device1] = $this->createVehicleDeviceWithUser($user1, $vehicle, $device);

        [$user2, $vehicle2, $device2] = $this->createUserVehicleDevice($vehicle, $device);

        $data = $this->dataWithUserVehicleDeviceMake($user2, $vehicle2, $device2);

        $response = $this->post($this->routeToController(), $data + $this->action())
            ->assertStatus(302)
            ->assertRedirect(route($this->routeCreateToUpdate($redirect), $this->rowLast()->id));

        $row = $this->rowLast();

        $this->dataVsRow($data, $row, $exclude);

        $this->assertEquals($row->user_id, $user2->id);

        if ($vehicle) {
            $this->assertEquals($row->vehicle_id, $vehicle2->id);
        }

        if ($device) {
            $this->assertEquals($row->device_id, $device2->id);
        }

        return $response;
    }

    /**
     * @param array $exclude = []
     *
     * @return void
     */
    public function postAuthUpdateSuccess(array $exclude = []): void
    {
        $this->authUser();

        $row = $this->factoryCreate();
        $data = $this->factoryMake()->toArray();

        $this->post(route($this->route, $row->id), $data + $this->action())
            ->assertStatus(302)
            ->assertRedirect(route($this->route, $row->id));

        $this->dataVsRow($data, $this->rowLast(), $exclude);
    }

    /**
     * @param bool $vehicle = true
     * @param bool $device = true
     *
     * @return \Illuminate\Testing\TestResponse
     */
    public function postAuthUpdateAdminFail(bool $vehicle = true, bool $device = true): TestResponse
    {
        $user1 = $this->authUserAdmin(true, false);

        [$user1, $row] = $this->createUserRow($user1);

        $data = $this->dataWithUserVehicleDeviceMake($this->createUser());

        $response = $this->post(route($this->route, $row->id), $data + $this->action())
            ->assertStatus(302)
            ->assertRedirect(route($this->route, $row->id));

        $this->assertEquals($this->rowLast()->user_id, $user1->id);

        return $response;
    }

    /**
     * @return \Illuminate\Testing\TestResponse
     */
    public function getAuthUpdateAdminSuccess(): TestResponse
    {
        $user1 = $this->authUserAdmin(true, false);

        [$user1, $row1] = $this->createUserRow($user1);
        [$user2, $row2] = $this->createUserRow();

        $this->get(route($this->route, $row2->id))
            ->assertStatus(404);

        return $this->get(route($this->route, $row1->id))
            ->assertStatus(200)
            ->assertDontSeeText($user2->name);
    }

    /**
     * @param array $exclude = []
     *
     * @return void
     */
    public function postAuthUpdateAdminSuccess(array $exclude = []): void
    {
        $this->authUserAdmin();

        $row = $this->factoryCreate();
        $data = $this->factoryMake()->toArray();

        $this->post(route($this->route, $row->id), $data + $this->action())
            ->assertStatus(302)
            ->assertRedirect(route($this->route, $row->id));

        $this->dataVsRow($data, $this->rowLast(), $exclude);
    }

    /**
     * @param bool $vehicle = true
     * @param bool $device = true
     *
     * @return \Illuminate\Testing\TestResponse
     */
    public function getAuthUpdateAdminModeSuccess(bool $vehicle = true, bool $device = true): TestResponse
    {
        $user1 = $this->authUserAdmin(true, true);

        [$vehicle1, $device1, $row1] = $this->createVehicleDeviceRowWithUser($user1, $vehicle, $device);
        [$user2, $vehicle2, $device2, $row2] = $this->createUserVehicleDeviceRow($vehicle, $device);

        $response = $this->get(route($this->route, $row1->id).'?user_id=')
            ->assertStatus(200)
            ->assertSeeText($user1->name)
            ->assertSeeText($user2->name);

        if ($vehicle) {
            $response->assertSeeText($vehicle1->name);
            $response->assertDontSeeText($vehicle2->name);
        }

        if ($device) {
            $response->assertSeeText($device1->name);
            $response->assertDontSeeText($device2->name);
        }

        $response = $this->get(route($this->route, $row1->id).'?user_id='.$user1->id)
            ->assertStatus(200)
            ->assertSeeText($user1->name)
            ->assertSeeText($user2->name);

        if ($vehicle) {
            $response->assertSeeText($vehicle1->name);
            $response->assertDontSeeText($vehicle2->name);
        }

        if ($device) {
            $response->assertSeeText($device1->name);
            $response->assertDontSeeText($device2->name);
        }

        $response = $this->get(route($this->route, $row1->id).'?user_id='.$user2->id)
            ->assertStatus(200)
            ->assertSeeText($user1->name)
            ->assertSeeText($user2->name);

        if ($vehicle) {
            $response->assertSeeText($vehicle1->name);
            $response->assertDontSeeText($vehicle2->name);
        }

        if ($device) {
            $response->assertSeeText($device1->name);
            $response->assertDontSeeText($device2->name);
        }

        return $response;
    }

    /**
     * @param bool $vehicle = true
     * @param bool $device = true
     *
     * @return \Illuminate\Testing\TestResponse
     */
    public function postAuthUpdateAdminModeFail(bool $vehicle = true, bool $device = true): TestResponse
    {
        $user1 = $this->authUserAdmin(true, true);

        [$vehicle1, $device1, $row] = $this->createVehicleDeviceRowWithUser($user1, $vehicle, $device);
        [$user2, $vehicle2, $device2] = $this->createUserVehicleDevice($vehicle, $device);

        $data = $this->dataWithUserVehicleDeviceMake($user2, $vehicle2, $device2);

        return $this->post(route($this->route, $row->id), $data + $this->action())
            ->assertStatus(422);
    }

    /**
     * @param bool $vehicle = true
     * @param bool $device = true
     * @param array $exclude = []
     *
     * @return \Illuminate\Testing\TestResponse
     */
    public function postAuthUpdateAdminModeSuccess(bool $vehicle = true, bool $device = true, array $exclude = []): TestResponse
    {
        $user1 = $this->authUserAdmin(true, true);

        [$vehicle1, $device1] = $this->createVehicleDeviceWithUser($user1, $vehicle, $device);
        [$user2, $vehicle2, $device2, $row] = $this->createUserVehicleDeviceRow($vehicle, $device);

        if ($vehicle) {
            $vehicle2 = $this->createVehicle($user2);
        }

        if ($device) {
            $device2 = $this->createDevice($vehicle2);
        }

        $data = $this->dataWithUserVehicleDeviceMake($user2, $vehicle2, $device2);

        $response = $this->post(route($this->route, $row->id), $data + $this->action())
            ->assertStatus(302)
            ->assertRedirect(route($this->route, $row->id));

        $row = $this->rowLast();

        $this->assertEquals($row->user_id, $user2->id);

        if ($vehicle) {
            $this->assertEquals($row->vehicle_id, $vehicle2->id);
        }

        if ($device) {
            $this->assertEquals($row->device_id, $device2->id);
        }

        $this->dataVsRow(['user_id' => $row->user_id] + $data, $row, $exclude);

        return $response;
    }

    /**
     * @return void
     */
    public function getAuthDeleteFail(): void
    {
        $this->authUser();

        $this->get($this->routeToController())
            ->assertStatus(200);
    }

    /**
     * @param ?string $redirect = null
     *
     * @return void
     */
    public function getAuthDeleteSuccess(?string $redirect = null): void
    {
        $this->authUser();

        $this->get($this->routeToController())
            ->assertStatus(302)
            ->assertRedirect(route($this->routeUpdateToIndex($redirect)));
    }

    /**
     * @return void
     */
    public function postAuthDeleteFail(): void
    {
        $this->authUser();

        $this->post($this->routeToController(), $this->action())
            ->assertStatus(200);
    }

    /**
     * @param ?string $redirect = null
     *
     * @return void
     */
    public function postAuthDeleteSuccess(?string $redirect = null): void
    {
        $this->authUser();

        $this->post($this->routeToController(), $this->action())
            ->assertStatus(302)
            ->assertRedirect(route($this->routeUpdateToIndex($redirect)));
    }

    /**
     * @return void
     */
    public function getAuthAdminDeleteFail(): void
    {
        $this->authUserAdmin(true, false);

        [$user2, $row2] = $this->createUserRow();

        $this->get(route($this->route, $row2->id), $this->action())
            ->assertStatus(404);
    }

    /**
     * @return void
     */
    public function postAuthAdminDeleteFail(): void
    {
        $this->authUserAdmin(true, false);

        [$user2, $row2] = $this->createUserRow();

        $this->post(route($this->route, $row2->id), $this->action())
            ->assertStatus(404);
    }

    /**
     * @param ?string $redirect = null
     *
     * @return void
     */
    public function getAuthAdminModeDeleteSuccess(?string $redirect = null): void
    {
        $this->authUserAdmin(true, true);

        [$user2, $row2] = $this->createUserRow();

        $this->get(route($this->route, $row2->id))
            ->assertStatus(302)
            ->assertRedirect(route($this->routeUpdateToIndex($redirect)));
    }

    /**
     * @param ?string $redirect = null
     *
     * @return void
     */
    public function postAuthAdminModeDeleteSuccess(?string $redirect = null): void
    {
        $user1 = $this->authUserAdmin(true, true);

        [$user2, $row2] = $this->createUserRow();

        $this->post(route($this->route, $row2->id), $this->action())
            ->assertStatus(302)
            ->assertRedirect(route($this->routeUpdateToIndex($redirect)));
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

    /**
     * @param ?string $redirect = null
     *
     * @return string
     */
    protected function routeCreateToUpdate(?string $redirect = null): string
    {
        return $redirect ?: str_replace('.create', '.update', $this->route);
    }

    /**
     * @param ?string $redirect = null
     *
     * @return string
     */
    protected function routeUpdateToIndex(?string $redirect = null): string
    {
        return $redirect ?: str_replace('.update', '.index', $this->route);
    }
}
