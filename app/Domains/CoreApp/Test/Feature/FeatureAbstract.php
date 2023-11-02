<?php declare(strict_types=1);

namespace App\Domains\CoreApp\Test\Feature;

use Illuminate\Testing\TestResponse;
use App\Domains\Core\Test\Feature\FeatureAbstract as FeatureAbstractCore;
use App\Domains\Device\Model\Device as DeviceModel;
use App\Domains\User\Model\User as UserModel;
use App\Domains\Vehicle\Model\Vehicle as VehicleModel;

abstract class FeatureAbstract extends FeatureAbstractCore
{
    /**
     * @return array
     */
    protected function createUserVehicleDevice(): array
    {
        $user = $this->factoryCreate(UserModel::class);
        $vehicle = $this->factoryCreate(VehicleModel::class, ['user_id' => $user->id]);
        $device = $this->factoryCreate(DeviceModel::class, ['user_id' => $user->id, 'vehicle_id' => $vehicle->id]);

        return [$user, $vehicle, $device];
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
     * @param ?string $redirect = null
     * @param array $exclude = []
     *
     * @return void
     */
    public function postAuthAdminCreateSuccess(?string $redirect = null, array $exclude = []): void
    {
        $this->authUserAdmin();

        $data = $this->factoryMake()->toArray();

        $this->post($this->routeToController(), $data + $this->action())
            ->assertStatus(302)
            ->assertRedirect(route($redirect ?? $this->route, $this->rowLast()->id));

        $this->dataVsRow($data, $this->rowLast(), $exclude);
    }

    /**
     * @param array $exclude = []
     *
     * @return void
     */
    public function postAuthAdminUpdateSuccess(array $exclude = []): void
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
     *
     * @return void
     */
    public function getAuthListOnlyOwnSucess(string $name = 'name', bool $vehicle = true, bool $device = true): void
    {
        [$user1, $vehicle1, $device1] = $this->createUserVehicleDevice();
        [$user2, $vehicle2, $device2] = $this->createUserVehicleDevice();

        $row1 = $this->factoryCreate(data: ['user_id' => $user1->id]);
        $row2 = $this->factoryCreate(data: ['user_id' => $user2->id]);

        $this->auth($user1);

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
     *
     * @return \Illuminate\Testing\TestResponse
     */
    public function getAuthListAdminSuccess(string $name = 'name', bool $vehicle = true, bool $device = true): TestResponse
    {
        [$user1, $vehicle1, $device1] = $this->createUserVehicleDevice();
        [$user2, $vehicle2, $device2] = $this->createUserVehicleDevice();

        $row1 = $this->factoryCreate(data: ['user_id' => $user1->id]);
        $row2 = $this->factoryCreate(data: ['user_id' => $user2->id]);

        $user1->admin = true;
        $user1->admin_mode = false;
        $user1->save();

        $this->auth($user1);

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
     *
     * @return \Illuminate\Testing\TestResponse
     */
    public function getAuthListAdminModeSuccess(string $name = 'name', bool $vehicle = true, bool $device = true): TestResponse
    {
        [$user1, $vehicle1, $device1] = $this->createUserVehicleDevice();
        [$user2, $vehicle2, $device2] = $this->createUserVehicleDevice();

        $row1 = $this->factoryCreate(data: ['user_id' => $user1->id]);
        $row2 = $this->factoryCreate(data: ['user_id' => $user2->id]);

        $user1->admin = true;
        $user1->admin_mode = true;
        $user1->save();

        $this->auth($user1);

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
     * @param array $skip = []
     *
     * @return void
     */
    public function postAuthCreateSuccess(?string $redirect = null, array $skip = []): void
    {
        $this->authUser();

        $data = $this->factoryMake()->toArray();

        $this->post($this->routeToController(), $data + $this->action())
            ->assertStatus(302)
            ->assertRedirect(route($redirect ?? $this->route, $this->rowLast()->id));

        $this->dataVsRow($data, $this->rowLast(), $skip);
    }

    /**
     * @return \Illuminate\Testing\TestResponse
     */
    public function getAuthCreateAdminSuccess(): TestResponse
    {
        [$user1, $vehicle1, $device1] = $this->createUserVehicleDevice();
        [$user2, $vehicle2, $device2] = $this->createUserVehicleDevice();

        $row1 = $this->factoryCreate(data: ['user_id' => $user1->id]);
        $row2 = $this->factoryCreate(data: ['user_id' => $user2->id]);

        $this->assertEquals($row1->user_id, $user1->id);
        $this->assertEquals($row2->user_id, $user2->id);

        $user1->admin = true;
        $user1->admin_mode = false;
        $user1->save();

        $this->auth($user1);

        return $this->get($this->routeToController())
            ->assertStatus(200)
            ->assertDontSeeText($user2->name);
    }

    /**
     * @param bool $vehicle = true
     * @param bool $device = true
     *
     * @return \Illuminate\Testing\TestResponse
     */
    public function getAuthCreateAdminModeSuccess(bool $vehicle = true, bool $device = true): TestResponse
    {
        [$user1, $vehicle1, $device1] = $this->createUserVehicleDevice();
        [$user2, $vehicle2, $device2] = $this->createUserVehicleDevice();

        $row1 = $this->factoryCreate(data: ['user_id' => $user1->id]);
        $row2 = $this->factoryCreate(data: ['user_id' => $user2->id]);

        $this->assertEquals($row1->user_id, $user1->id);
        $this->assertEquals($row2->user_id, $user2->id);

        $user1->admin = true;
        $user1->admin_mode = true;
        $user1->save();

        $this->auth($user1);

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
     * @param ?string $redirect = null
     *
     * @return \Illuminate\Testing\TestResponse
     */
    public function postAuthCreateAdminSuccess(?string $redirect = null): TestResponse
    {
        [$user1, $vehicle1, $device1] = $this->createUserVehicleDevice();
        [$user2, $vehicle2, $device2] = $this->createUserVehicleDevice();

        $user1->admin = true;
        $user1->admin_mode = false;
        $user1->save();

        $this->auth($user1);

        $data = ['user_id' => $user2->id] + $this->factoryMake()->toArray();

        $response = $this->post($this->routeToController(), $data + $this->action())
            ->assertStatus(302)
            ->assertRedirect(route($redirect ?? $this->route, $this->rowLast()->id));

        $this->assertEquals($this->rowLast()->user_id, $user1->id);

        return $response;
    }

    /**
     * @param ?string $redirect = null
     * @param bool $vehicle = true
     * @param bool $device = true
     *
     * @return \Illuminate\Testing\TestResponse
     */
    public function postAuthCreateAdminModeSuccess(?string $redirect = null, bool $vehicle = true, bool $device = true): TestResponse
    {
        [$user1, $vehicle1, $device1] = $this->createUserVehicleDevice();
        [$user2, $vehicle2, $device2] = $this->createUserVehicleDevice();

        $user1->admin = true;
        $user1->admin_mode = true;
        $user1->save();

        $this->auth($user1);

        $data = [
            'user_id' => $user2->id,
            'vehicle_id' => $vehicle2->id,
            'device_id' => $device2->id,
        ] + $this->factoryMake()->toArray();

        $response = $this->post($this->routeToController(), $data + $this->action())
            ->assertStatus(302)
            ->assertRedirect(route($redirect ?? $this->route, $this->rowLast()->id));

        $row = $this->rowLast();

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
     * @return \Illuminate\Testing\TestResponse
     */
    public function postAuthCreateAdminModeFail(): TestResponse
    {
        [$user1, $vehicle1, $device1] = $this->createUserVehicleDevice();
        [$user2, $vehicle2, $device2] = $this->createUserVehicleDevice();

        $user1->admin = true;
        $user1->admin_mode = true;
        $user1->save();

        $this->auth($user1);

        $data = [
            'user_id' => $user2->id,
            'vehicle_id' => $vehicle1->id,
            'device_id' => $device1->id,
        ] + $this->factoryMake()->toArray();

        return $this->post($this->routeToController(), $data + $this->action())
            ->assertStatus(422);
    }

    /**
     * @return \Illuminate\Testing\TestResponse
     */
    public function getAuthUpdateAdminSuccess(): TestResponse
    {
        [$user1, $vehicle1, $device1] = $this->createUserVehicleDevice();
        [$user2, $vehicle2, $device2] = $this->createUserVehicleDevice();

        $row1 = $this->factoryCreate(data: ['user_id' => $user1->id]);
        $row2 = $this->factoryCreate(data: ['user_id' => $user2->id]);

        $this->assertEquals($row1->user_id, $user1->id);
        $this->assertEquals($row2->user_id, $user2->id);

        $user1->admin = true;
        $user1->admin_mode = false;
        $user1->save();

        $this->auth($user1);

        $this->get(route($this->route, $row2->id))
            ->assertStatus(404);

        return $this->get(route($this->route, $row1->id))
            ->assertStatus(200)
            ->assertDontSeeText($user2->name);
    }

    /**
     * @param bool $vehicle = true
     * @param bool $device = true
     *
     * @return \Illuminate\Testing\TestResponse
     */
    public function getAuthUpdateAdminModeSuccess(bool $vehicle = true, bool $device = true): TestResponse
    {
        [$user1, $vehicle1, $device1] = $this->createUserVehicleDevice();
        [$user2, $vehicle2, $device2] = $this->createUserVehicleDevice();

        $row1 = $this->factoryCreate(data: ['user_id' => $user1->id]);
        $row2 = $this->factoryCreate(data: ['user_id' => $user2->id]);

        $this->assertEquals($row1->user_id, $user1->id);
        $this->assertEquals($row2->user_id, $user2->id);

        $user1->admin = true;
        $user1->admin_mode = true;
        $user1->save();

        $this->auth($user1);

        $response = $this->get(route($this->route, $row1->id).'?user_id=')
            ->assertStatus(200)
            ->assertSeeText($user1->name)
            ->assertSeeText($user2->name);

        if ($vehicle) {
            $response->assertDontSeeText($vehicle1->name);
            $response->assertDontSeeText($vehicle2->name);
        }

        if ($device) {
            $response->assertDontSeeText($device1->name);
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
            $response->assertDontSeeText($vehicle1->name);
            $response->assertSeeText($vehicle2->name);
        }

        if ($device) {
            $response->assertDontSeeText($device1->name);
            $response->assertSeeText($device2->name);
        }

        $response = $this->get(route($this->route, $row2->id).'?user_id=')
            ->assertStatus(200)
            ->assertSeeText($user1->name)
            ->assertSeeText($user2->name);

        if ($vehicle) {
            $response->assertDontSeeText($vehicle1->name);
            $response->assertDontSeeText($vehicle2->name);
        }

        if ($device) {
            $response->assertDontSeeText($device1->name);
            $response->assertDontSeeText($device2->name);
        }

        $response = $this->get(route($this->route, $row2->id).'?user_id='.$user2->id)
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

        $response = $this->get(route($this->route, $row2->id).'?user_id='.$user1->id)
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
     * @param array $skip = []
     *
     * @return void
     */
    public function postAuthUpdateSuccess(array $skip = []): void
    {
        $this->authUser();

        $row = $this->factoryCreate();
        $data = $this->factoryMake()->toArray();

        $this->post(route($this->route, $row->id), $data + $this->action())
            ->assertStatus(302)
            ->assertRedirect(route($this->route, $row->id));

        $this->dataVsRow($data, $this->rowLast(), $skip);
    }

    /**
     * @return \Illuminate\Testing\TestResponse
     */
    public function postAuthUpdateAdminSuccess(): TestResponse
    {
        [$user1, $vehicle1, $device1] = $this->createUserVehicleDevice();
        [$user2, $vehicle2, $device2] = $this->createUserVehicleDevice();

        $row = $this->factoryCreate(data: ['user_id' => $user1->id]);

        $this->assertEquals($row->user_id, $user1->id);

        $user1->admin = true;
        $user1->admin_mode = false;
        $user1->save();

        $this->auth($user1);

        $data = ['user_id' => $user2->id] + $this->factoryMake()->toArray();

        $response = $this->post(route($this->route, $row->id), $data + $this->action())
            ->assertStatus(302)
            ->assertRedirect(route($this->route, $row->id));

        $this->assertEquals($this->rowLast()->user_id, $user1->id);

        return $response;
    }

    /**
     * @param bool $vehicle = true
     * @param bool $device = true
     *
     * @return \Illuminate\Testing\TestResponse
     */
    public function postAuthUpdateAdminModeSuccess(bool $vehicle = true, bool $device = true): TestResponse
    {
        [$user1, $vehicle1, $device1] = $this->createUserVehicleDevice();
        [$user2, $vehicle2, $device2] = $this->createUserVehicleDevice();

        $row = $this->factoryCreate(data: ['user_id' => $user1->id]);

        $this->assertEquals($row->user_id, $user1->id);

        $user1->admin = true;
        $user1->admin_mode = true;
        $user1->save();

        $this->auth($user1);

        $data = [
            'user_id' => $user2->id,
            'vehicle_id' => $vehicle2->id,
            'device_id' => $device2->id,
        ] + $this->factoryMake()->toArray();

        $response = $this->post(route($this->route, $row->id), $data + $this->action())
            ->assertStatus(302)
            ->assertRedirect(route($this->route, $row->id));

        $row = $this->rowLast();

        $this->assertEquals($row->user_id, $user1->id);

        if ($vehicle) {
            $this->assertEquals($row->vehicle_id, $vehicle1->id);
        }

        if ($device) {
            $this->assertEquals($row->device_id, $device1->id);
        }

        return $response;
    }

    /**
     * @return \Illuminate\Testing\TestResponse
     */
    public function postAuthUpdateAdminModeFail(): TestResponse
    {
        [$user1, $vehicle1, $device1] = $this->createUserVehicleDevice();
        [$user2, $vehicle2, $device2] = $this->createUserVehicleDevice();

        $row = $this->factoryCreate(data: ['user_id' => $user1->id]);

        $this->assertEquals($row->user_id, $user1->id);

        $user1->admin = true;
        $user1->admin_mode = true;
        $user1->save();

        $this->auth($user1);

        $data = [
            'user_id' => $user2->id,
            'vehicle_id' => $vehicle1->id,
            'device_id' => $device1->id,
        ] + $this->factoryMake()->toArray();

        return $this->post(route($this->route, $row->id), $data + $this->action())
            ->assertStatus(422);
    }

    /**
     * @param string $redirect
     *
     * @return void
     */
    public function getAuthDeleteSuccess(string $redirect): void
    {
        $this->authUser();

        $this->get($this->routeToController())
            ->assertStatus(302)
            ->assertRedirect(route($redirect));
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
     * @param string $redirect
     *
     * @return void
     */
    public function postAuthDeleteSuccess(string $redirect): void
    {
        $this->authUser();

        $this->post($this->routeToController(), $this->action())
            ->assertStatus(302)
            ->assertRedirect(route($redirect));
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
     * @return void
     */
    public function getAuthAdminDeleteFail(): void
    {
        [$user1, $vehicle1, $device1] = $this->createUserVehicleDevice();
        [$user2, $vehicle2, $device2] = $this->createUserVehicleDevice();

        $row = $this->factoryCreate(data: ['user_id' => $user2->id]);

        $this->assertEquals($row->user_id, $user2->id);

        $user1->admin = true;
        $user1->admin_mode = false;
        $user1->save();

        $this->auth($user1);

        $this->get(route($this->route, $row->id), $this->action())
            ->assertStatus(404);
    }

    /**
     * @return void
     */
    public function postAuthAdminDeleteFail(): void
    {
        [$user1, $vehicle1, $device1] = $this->createUserVehicleDevice();
        [$user2, $vehicle2, $device2] = $this->createUserVehicleDevice();

        $row = $this->factoryCreate(data: ['user_id' => $user2->id]);

        $this->assertEquals($row->user_id, $user2->id);

        $user1->admin = true;
        $user1->admin_mode = false;
        $user1->save();

        $this->auth($user1);

        $this->post(route($this->route, $row->id), $this->action())
            ->assertStatus(404);
    }

    /**
     * @param string $redirect
     *
     * @return void
     */
    public function getAuthAdminModeDeleteSuccess(string $redirect): void
    {
        [$user1, $vehicle1, $device1] = $this->createUserVehicleDevice();
        [$user2, $vehicle2, $device2] = $this->createUserVehicleDevice();

        $row = $this->factoryCreate(data: ['user_id' => $user2->id]);

        $this->assertEquals($row->user_id, $user2->id);

        $user1->admin = true;
        $user1->admin_mode = true;
        $user1->save();

        $this->auth($user1);

        $this->get(route($this->route, $row->id))
            ->assertStatus(302)
            ->assertRedirect(route($redirect));
    }

    /**
     * @param string $redirect
     *
     * @return void
     */
    public function postAuthAdminModeDeleteSuccess(string $redirect): void
    {
        [$user1, $vehicle1, $device1] = $this->createUserVehicleDevice();
        [$user2, $vehicle2, $device2] = $this->createUserVehicleDevice();

        $row = $this->factoryCreate(data: ['user_id' => $user2->id]);

        $this->assertEquals($row->user_id, $user2->id);

        $user1->admin = true;
        $user1->admin_mode = true;
        $user1->save();

        $this->auth($user1);

        $this->post(route($this->route, $row->id), $this->action())
            ->assertStatus(302)
            ->assertRedirect(route($redirect));
    }
}
