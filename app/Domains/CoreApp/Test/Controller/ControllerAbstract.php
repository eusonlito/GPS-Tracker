<?php declare(strict_types=1);

namespace App\Domains\CoreApp\Test\Controller;

use Illuminate\Testing\TestResponse;
use App\Domains\CoreApp\Test\Feature\FeatureAbstract;

abstract class ControllerAbstract extends FeatureAbstract
{
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
    public function getAuthAdminInvalidFail(): void
    {
        $this->authUserAdmin();

        $this->get($this->routeFactoryCreateModel(null, 'invalid'))
            ->assertStatus(422);
    }

    /**
     * @return void
     */
    public function getJsonAuthAdminInvalidFail(): void
    {
        $this->authUserAdmin();

        $this->getJson($this->routeFactoryCreateModel(null, 'invalid'))
            ->assertStatus(422);
    }

    /**
     * @return void
     */
    public function postAuthAdminInvalidFail(): void
    {
        $this->authUserAdmin();

        $this->post($this->routeFactoryCreateModel(null, 'invalid'))
            ->assertStatus(422);
    }

    /**
     * @return void
     */
    public function postJsonAuthAdminInvalidFail(): void
    {
        $this->authUserAdmin();

        $this->postJson($this->routeFactoryCreateModel(null, 'invalid'))
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
    public function getJsonAuthAdminSuccess(): void
    {
        $this->authUserAdmin();

        $this->getJson($this->routeToController())
            ->assertStatus(200);

        $this->factoryCreate();

        $this->getJson($this->routeToController())
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
     * @return void
     */
    public function postJsonAuthAdminSuccess(): void
    {
        $this->authUserAdmin();

        $this->postJson($this->routeToController())
            ->assertStatus(200);

        $this->factoryCreate();

        $this->postJson($this->routeToController())
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
        $user1 = $this->authUserAdmin();
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
    public function getAuthListManagerSuccess(string $name = 'name', bool $vehicle = true, bool $device = true, bool $multiple = false): TestResponse
    {
        $user1 = $this->authUserManager();
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
     * @param array $only = []
     *
     * @return void
     */
    public function postAuthCreateSuccess(?string $redirect = null, array $exclude = [], array $only = []): void
    {
        $this->authUser();

        $data = $this->factoryMake()->toArray();

        $this->post($this->routeToController(), $data + $this->action())
            ->assertStatus(302)
            ->assertRedirect(route($this->routeCreateToUpdate($redirect), $this->rowLast()->id));

        $this->dataVsRow($data, $this->rowLast(), $exclude, $only);
    }

    /**
     * @param bool $vehicle = true
     * @param bool $device = true
     *
     * @return \Illuminate\Testing\TestResponse
     */
    public function getAuthCreateAdminSuccess(bool $vehicle = true, bool $device = true): TestResponse
    {
        $user1 = $this->authUserAdmin();

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
        $user1 = $this->authUserAdmin();

        [$user2, $vehicle2, $device2] = $this->createUserVehicleDevice($vehicle, $device);

        $data = $this->dataWithUserVehicleDeviceMake($user2);

        $response = $this->post($this->routeToController(), $data + $this->action())
            ->assertStatus(302)
            ->assertRedirect(route($this->routeCreateToUpdate($redirect), $this->rowLast()->id));

        $this->assertEquals($user1->id, $this->rowLast()->user_id);

        return $response;
    }

    /**
     * @param ?string $redirect = null
     * @param array $exclude = []
     * @param array $only = []
     *
     * @return void
     */
    public function postAuthCreateAdminSuccess(?string $redirect = null, array $exclude = [], array $only = []): void
    {
        $this->authUserAdmin();

        $data = $this->factoryMake()->toArray();

        $this->post($this->routeToController(), $data + $this->action())
            ->assertStatus(302)
            ->assertRedirect(route($this->routeCreateToUpdate($redirect), $this->rowLast()->id));

        $this->dataVsRow($data, $this->rowLast(), $exclude, $only);
    }

    /**
     * @param bool $vehicle = true
     * @param bool $device = true
     *
     * @return \Illuminate\Testing\TestResponse
     */
    public function getAuthCreateManagerSuccess(bool $vehicle = true, bool $device = true): TestResponse
    {
        $user1 = $this->authUserManager();

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
    public function postAuthCreateManagerFail(bool $vehicle = true, bool $device = true): TestResponse
    {
        $user1 = $this->authUserManager();

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
     * @param array $only = []
     *
     * @return \Illuminate\Testing\TestResponse
     */
    public function postAuthCreateManagerSuccess(?string $redirect = null, bool $vehicle = true, bool $device = true, array $exclude = [], array $only = []): TestResponse
    {
        $user1 = $this->authUserManager();

        [$vehicle1, $device1] = $this->createVehicleDeviceWithUser($user1, $vehicle, $device);

        [$user2, $vehicle2, $device2] = $this->createUserVehicleDevice($vehicle, $device);

        $data = $this->dataWithUserVehicleDeviceMake($user2, $vehicle2, $device2);

        $response = $this->post($this->routeToController(), $data + $this->action())
            ->assertStatus(302)
            ->assertRedirect(route($this->routeCreateToUpdate($redirect), $this->rowLast()->id));

        $row1 = $this->rowLast();

        $this->dataVsRow($data, $row1, $exclude, $only);

        $this->assertEquals($user2->id, $row1->user_id, '$user2->id, $row1->user_id');

        if ($vehicle) {
            $this->assertEquals($vehicle2->id, $row1->vehicle_id, '$vehicle2->id, $row1->vehicle_id');
        }

        if ($device) {
            $this->assertEquals($device2->id, $row1->device_id, '$device2->id, $row1->device_id');
        }

        return $response;
    }

    /**
     * @param array $exclude = []
     * @param array $only = []
     *
     * @return void
     */
    public function postAuthUpdateSuccess(array $exclude = [], array $only = []): void
    {
        $this->authUser();

        $row = $this->factoryCreate();
        $data = $this->factoryMake()->toArray();

        $this->post(route($this->route, $row->id), $data + $this->action())
            ->assertStatus(302)
            ->assertRedirect(route($this->route, $row->id));

        $this->dataVsRow($data, $this->rowLast(), $exclude, $only);
    }

    /**
     * @param bool $vehicle = true
     * @param bool $device = true
     *
     * @return \Illuminate\Testing\TestResponse
     */
    public function postAuthUpdateAdminFail(bool $vehicle = true, bool $device = true): TestResponse
    {
        $user = $this->authUserAdmin();

        [$user, $row] = $this->createUserRow($user);

        $data = $this->dataWithUserVehicleDeviceMake($this->createUser());

        $response = $this->post(route($this->route, $row->id), $data + $this->action())
            ->assertStatus(302)
            ->assertRedirect(route($this->route, $row->id));

        $this->assertEquals($user->id, $this->rowLast()->user_id);

        return $response;
    }

    /**
     * @return \Illuminate\Testing\TestResponse
     */
    public function getAuthUpdateAdminSuccess(): TestResponse
    {
        $user1 = $this->authUserAdmin();

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
     * @param array $only = []
     *
     * @return void
     */
    public function postAuthUpdateAdminSuccess(array $exclude = [], array $only = []): void
    {
        $this->authUserAdmin();

        $row = $this->factoryCreate();
        $data = $this->factoryMake()->toArray();

        $this->post(route($this->route, $row->id), $data + $this->action())
            ->assertStatus(302)
            ->assertRedirect(route($this->route, $row->id));

        $this->dataVsRow($data, $this->rowLast(), $exclude, $only);
    }

    /**
     * @param bool $vehicle = true
     * @param bool $device = true
     *
     * @return \Illuminate\Testing\TestResponse
     */
    public function getAuthUpdateManagerSuccess(bool $vehicle = true, bool $device = true): TestResponse
    {
        $user1 = $this->authUserManager();

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
     * @return \Illuminate\Testing\TestResponse
     */
    public function getAuthUpdateManagerNoUserSuccess(): TestResponse
    {
        $user1 = $this->authUserManager();

        [$user1, $row1] = $this->createUserRow($user1);
        [$user2, $row2] = $this->createUserRow();

        $response = $this->get(route($this->route, $row1->id))
            ->assertStatus(200);

        $response = $this->get(route($this->route, $row2->id))
            ->assertStatus(200);

        return $response;
    }

    /**
     * @param bool $vehicle = true
     * @param bool $device = true
     *
     * @return \Illuminate\Testing\TestResponse
     */
    public function postAuthUpdateManagerFail(bool $vehicle = true, bool $device = true): TestResponse
    {
        $user1 = $this->authUserManager();

        [$vehicle1, $device1, $row1] = $this->createVehicleDeviceRowWithUser($user1, $vehicle, $device);
        [$user2, $vehicle2, $device2] = $this->createUserVehicleDevice($vehicle, $device);

        $data = $this->dataWithUserVehicleDeviceMake($user2, $vehicle2, $device2);

        return $this->post(route($this->route, $row1->id), $data + $this->action())
            ->assertStatus(422);
    }

    /**
     * @param bool $vehicle = true
     * @param bool $device = true
     * @param array $exclude = []
     * @param array $only = []
     *
     * @return \Illuminate\Testing\TestResponse
     */
    public function postAuthUpdateManagerSuccess(bool $vehicle = true, bool $device = true, array $exclude = [], array $only = []): TestResponse
    {
        $user1 = $this->authUserManager();

        [$vehicle1, $device1] = $this->createVehicleDeviceWithUser($user1, $vehicle, $device);
        [$user2, $vehicle2, $device2, $row2] = $this->createUserVehicleDeviceRow($vehicle, $device);

        if ($vehicle) {
            $vehicle2 = $this->createVehicle($user2);
        }

        if ($device) {
            $device2 = $this->createDevice($vehicle2);
        }

        $data = $this->dataWithUserVehicleDeviceMake($user2, $vehicle2, $device2);

        $response = $this->post(route($this->route, $row2->id), $data + $this->action())
            ->assertStatus(302)
            ->assertRedirect(route($this->route, $row2->id));

        $row2 = $this->rowFresh($row2);

        $this->assertEquals($user2->id, $row2->user_id, '$user2->id, $row2->user_id');

        if ($vehicle) {
            $this->assertEquals($vehicle2->id, $row2->vehicle_id, '$vehicle2->id, $row2->vehicle_id');
        }

        if ($device) {
            $this->assertEquals($device2->id, $row2->device_id, '$device2->id, $row2->device_id');
        }

        $this->dataVsRow(['user_id' => $row2->user_id] + $data, $row2, $exclude, $only);

        return $response;
    }

    /**
     * @param array $exclude = []
     * @param array $only = []
     *
     * @return \Illuminate\Testing\TestResponse
     */
    public function postAuthUpdateManagerNoUserSuccess(array $exclude = [], array $only = []): TestResponse
    {
        $user1 = $this->authUserManager();

        [$user1, $row1] = $this->createUserRow($user1);
        [$user2, $row2] = $this->createUserRow();

        $data = $this->factoryMake()->toArray();

        $response = $this->post(route($this->route, $row1->id), $data + $this->action())
            ->assertStatus(302)
            ->assertRedirect(route($this->route, $row1->id));

        $row1 = $this->rowFresh($row1);

        $this->assertEquals($user1->id, $row1->user_id, '$user1->id, $row1->user_id');

        $this->dataVsRow(['user_id' => $row1->user_id] + $data, $row1, $exclude, $only);

        $data = $this->factoryMake()->toArray();

        $response = $this->post(route($this->route, $row2->id), $data + $this->action())
            ->assertStatus(302)
            ->assertRedirect(route($this->route, $row2->id));

        $row2 = $this->rowFresh($row2);

        $this->assertEquals($user2->id, $row2->user_id, '$user2->id, $row2->user_id');

        $this->dataVsRow(['user_id' => $row2->user_id] + $data, $row2, $exclude, $only);

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
        $this->authUserAdmin();

        [$user2, $row2] = $this->createUserRow();

        $this->get(route($this->route, $row2->id), $this->action())
            ->assertStatus(404);
    }

    /**
     * @return void
     */
    public function postAuthAdminDeleteFail(): void
    {
        $this->authUserAdmin();

        [$user2, $row2] = $this->createUserRow();

        $this->post(route($this->route, $row2->id), $this->action())
            ->assertStatus(404);
    }

    /**
     * @param ?string $redirect = null
     *
     * @return void
     */
    public function postAuthAdminDeleteSuccess(?string $redirect = null): void
    {
        $this->authUserAdmin();

        $this->post($this->routeToController(), $this->action())
            ->assertStatus(302)
            ->assertRedirect(route($this->routeUpdateToIndex($redirect)));
    }

    /**
     * @param ?string $redirect = null
     *
     * @return void
     */
    public function getAuthManagerDeleteSuccess(?string $redirect = null): void
    {
        $this->authUserManager();

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
    public function postAuthManagerDeleteSuccess(?string $redirect = null): void
    {
        $user1 = $this->authUserManager();

        [$user2, $row2] = $this->createUserRow();

        $this->post(route($this->route, $row2->id), $this->action())
            ->assertStatus(302)
            ->assertRedirect(route($this->routeUpdateToIndex($redirect)));
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
