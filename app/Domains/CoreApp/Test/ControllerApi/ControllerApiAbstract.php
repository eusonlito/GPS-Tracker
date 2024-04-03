<?php declare(strict_types=1);

namespace App\Domains\CoreApp\Test\ControllerApi;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Testing\TestResponse;
use App\Domains\CoreApp\Test\Feature\FeatureAbstract;

abstract class ControllerApiAbstract extends FeatureAbstract
{
    /**
     * @param \Illuminate\Contracts\Auth\Authenticatable $user
     * @param $guard = null
     *
     * @return self
     */
    public function actingAs(Authenticatable $user, $guard = null): self
    {
        $api_key = helper()->uuid();

        $user->api_key_prefix = explode('-', $api_key, 2)[0];
        $user->api_key = hash('sha256', $api_key);
        $user->api_key_enabled = true;
        $user->save();

        $this->withHeaders([
            'Authorization' => 'Bearer '.$api_key,
            'Accept' => 'application/json',
        ]);

        return $this;
    }

    /**
     * @param string $uri
     * @param array $headers = []
     *
     * @return \Illuminate\Testing\TestResponse
     */
    public function get($uri, array $headers = []): TestResponse
    {
        return $this->getJson($uri, $headers);
    }

    /**
     * @param string $uri
     * @param array $data = []
     * @param array $headers = []
     *
     * @return \Illuminate\Testing\TestResponse
     */
    public function post($uri, array $data = [], array $headers = []): TestResponse
    {
        return $this->postJson($uri, $data, $headers);
    }

    /**
     * @param string $uri
     * @param array $data = []
     * @param array $headers = []
     *
     * @return \Illuminate\Testing\TestResponse
     */
    public function patch($uri, array $data = [], array $headers = []): TestResponse
    {
        return $this->patchJson($uri, $data, $headers);
    }

    /**
     * @param string $uri
     * @param array $data = []
     * @param array $headers = []
     *
     * @return \Illuminate\Testing\TestResponse
     */
    public function delete($uri, array $data = [], array $headers = []): TestResponse
    {
        return $this->deleteJson($uri, $data, $headers);
    }

    /**
     * @return \Illuminate\Testing\TestResponse
     */
    public function getGuestUnauthorizedFail(): TestResponse
    {
        return $this->get($this->routeToController())
            ->assertStatus(401);
    }

    /**
     * @return \Illuminate\Testing\TestResponse
     */
    public function postGuestUnauthorizedFail(): TestResponse
    {
        return $this->post($this->routeToController())
            ->assertStatus(401);
    }

    /**
     * @return \Illuminate\Testing\TestResponse
     */
    public function patchGuestUnauthorizedFail(): TestResponse
    {
        return $this->patch($this->routeToController())
            ->assertStatus(401);
    }

    /**
     * @return \Illuminate\Testing\TestResponse
     */
    public function deleteGuestUnauthorizedFail(): TestResponse
    {
        return $this->delete($this->routeToController())
            ->assertStatus(401);
    }

    /**
     * @return \Illuminate\Testing\TestResponse
     */
    public function getGuestNotAllowedFail(): TestResponse
    {
        return $this->get($this->routeToController())
            ->assertStatus(405);
    }

    /**
     * @return \Illuminate\Testing\TestResponse
     */
    public function postGuestNotAllowedFail(): TestResponse
    {
        return $this->post($this->routeToController())
            ->assertStatus(405);
    }

    /**
     * @return \Illuminate\Testing\TestResponse
     */
    public function patchGuestNotAllowedFail(): TestResponse
    {
        return $this->patch($this->routeToController())
            ->assertStatus(405);
    }

    /**
     * @return \Illuminate\Testing\TestResponse
     */
    public function deleteGuestNotAllowedFail(): TestResponse
    {
        return $this->delete($this->routeToController())
            ->assertStatus(405);
    }

    /**
     * @return \Illuminate\Testing\TestResponse
     */
    public function getAuthNotAllowedFail(): TestResponse
    {
        $this->authUser();

        return $this->get($this->routeToController())
            ->assertStatus(405);
    }

    /**
     * @return \Illuminate\Testing\TestResponse
     */
    public function postAuthNotAllowedFail(): TestResponse
    {
        $this->authUser();

        return $this->post($this->routeToController())
            ->assertStatus(405);
    }

    /**
     * @return \Illuminate\Testing\TestResponse
     */
    public function getAuthUnauthorizedFail(): TestResponse
    {
        $this->authUser();

        return $this->get($this->routeToController())
            ->assertStatus(404)
            ->assertJsonStructure(['code', 'status', 'message', 'details']);
    }

    /**
     * @return \Illuminate\Testing\TestResponse
     */
    public function postAuthUnauthorizedFail(): TestResponse
    {
        $this->authUser();

        return $this->post($this->routeToController())
            ->assertStatus(404)
            ->assertJsonStructure(['code', 'status', 'message', 'details']);
    }

    /**
     * @return \Illuminate\Testing\TestResponse
     */
    public function getAuthSuccess(): TestResponse
    {
        $this->authUser();

        $this->get($this->routeToController())
            ->assertStatus(200)
            ->assertJson([]);

        $this->factoryCreate();

        return $this->get($this->routeToController())
            ->assertStatus(200)
            ->assertJson([]);
    }

    /**
     * @return \Illuminate\Testing\TestResponse
     */
    public function postAuthSuccess(): TestResponse
    {
        $this->authUser();

        $this->post($this->routeToController())
            ->assertStatus(200)
            ->assertJson([]);

        $this->factoryCreate();

        return $this->post($this->routeToController())
            ->assertStatus(200)
            ->assertJson([]);
    }

    /**
     * @return \Illuminate\Testing\TestResponse
     */
    public function getAuthInvalidFail(): TestResponse
    {
        $this->authUser();

        return $this->get($this->routeFactoryCreateModel(null, 'invalid'))
            ->assertStatus(422);
    }

    /**
     * @return \Illuminate\Testing\TestResponse
     */
    public function postAuthInvalidFail(): TestResponse
    {
        $this->authUser();

        return $this->post($this->routeFactoryCreateModel(null, 'invalid'))
            ->assertStatus(422);
    }

    /**
     * @return \Illuminate\Testing\TestResponse
     */
    public function getAuthAdminInvalidFail(): TestResponse
    {
        $this->authUserAdmin();

        return $this->get($this->routeFactoryCreateModel(null, 'invalid'))
            ->assertStatus(422);
    }

    /**
     * @return \Illuminate\Testing\TestResponse
     */
    public function postAuthAdminInvalidFail(): TestResponse
    {
        $this->authUserAdmin();

        return $this->post($this->routeFactoryCreateModel(null, 'invalid'))
            ->assertStatus(422);
    }

    /**
     * @return \Illuminate\Testing\TestResponse
     */
    public function getAuthAdminNotAllowedFail(): TestResponse
    {
        $this->authUserAdmin();

        return $this->get($this->routeToController())
            ->assertStatus(405);
    }

    /**
     * @return \Illuminate\Testing\TestResponse
     */
    public function postAuthAdminNotAllowedFail(): TestResponse
    {
        $this->authUserAdmin();

        return $this->post($this->routeToController())
            ->assertStatus(405);
    }

    /**
     * @return \Illuminate\Testing\TestResponse
     */
    public function getAuthAdminSuccess(): TestResponse
    {
        $this->authUserAdmin();

        $this->get($this->routeToController())
            ->assertStatus(200)
            ->assertJson([]);

        $this->factoryCreate();

        return $this->get($this->routeToController())
            ->assertStatus(200)
            ->assertJson([]);
    }

    /**
     * @return \Illuminate\Testing\TestResponse
     */
    public function postAuthAdminSuccess(): TestResponse
    {
        $this->authUserAdmin();

        $this->post($this->routeToController())
            ->assertStatus(200)
            ->assertJson([]);

        $this->factoryCreate();

        return $this->post($this->routeToController())
            ->assertStatus(200)
            ->assertJson([]);
    }

    /**
     * @param string $name = 'name'
     *
     * @return \Illuminate\Testing\TestResponse
     */
    public function getAuthListSuccess(string $name = 'name'): TestResponse
    {
        $this->authUser();

        $row = $this->factoryCreate();

        return $this->get($this->routeToController())
            ->assertStatus(200)
            ->assertJson([])
            ->assertSee($row->$name);
    }

    /**
     * @param string $name = 'name'
     * @param bool $vehicle = true
     * @param bool $device = true
     * @param bool $multiple = false
     *
     * @return \Illuminate\Testing\TestResponse
     */
    public function getAuthListOnlyOwnSucess(string $name = 'name', bool $vehicle = true, bool $device = true, bool $multiple = false): TestResponse
    {
        $user1 = $this->authUser();
        $user2 = $this->createUser();

        if ($multiple) {
            $this->createVehicleDeviceRowWithUser($user1, $vehicle, $device);
            $this->createVehicleDeviceRowWithUser($user2, $vehicle, $device);
        }

        [$vehicle1, $device1, $row1] = $this->createVehicleDeviceRowWithUser($user1, $vehicle, $device);
        [$vehicle2, $device2, $row2] = $this->createVehicleDeviceRowWithUser($user2, $vehicle, $device);

        $response = $this->get($this->routeToController())
            ->assertStatus(200)
            ->assertJson([])
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

        $response = $this->get($this->routeToController())
            ->assertStatus(200)
            ->assertJson([])
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

        $response = $this->get($this->routeToController())
            ->assertStatus(200)
            ->assertJson([])
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

        $response = $this->get($this->routeToController())
            ->assertStatus(200)
            ->assertJson([])
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

        $response = $this->get($this->routeToController().'?user_id='.$user2->id)
            ->assertStatus(200)
            ->assertJson([])
            ->assertDontSeeText($row1->$name)
            ->assertSeeText($row2->$name)
            ->assertDontSeeText($user1->name)
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
     * @param array $exclude = []
     * @param array $only = []
     *
     * @return \Illuminate\Testing\TestResponse
     */
    public function postAuthCreateSuccess(array $exclude = [], array $only = []): TestResponse
    {
        $this->authUser();

        $data = $this->factoryMake()->toArray();

        $response = $this->post($this->routeToController(), $data + $this->action())
            ->assertStatus(200)
            ->assertJson([]);

        $this->dataVsRow($data, $this->rowLast(), $exclude, $only);

        return $response;
    }

    /**
     * @param bool $vehicle = true
     * @param bool $device = true
     *
     * @return \Illuminate\Testing\TestResponse
     */
    public function postAuthCreateAdminFail(bool $vehicle = true, bool $device = true): TestResponse
    {
        $user1 = $this->authUserAdmin();

        [$user2, $vehicle2, $device2] = $this->createUserVehicleDevice($vehicle, $device);

        $data = $this->dataWithUserVehicleDeviceMake($user2);

        $response = $this->post($this->routeToController(), $data + $this->action())
            ->assertStatus(200)
            ->assertJson([]);

        $this->assertEquals($user1->id, $this->rowLast()->user_id);

        return $response;
    }

    /**
     * @param array $exclude = []
     * @param array $only = []
     *
     * @return \Illuminate\Testing\TestResponse
     */
    public function postAuthCreateAdminSuccess(array $exclude = [], array $only = []): TestResponse
    {
        $this->authUserAdmin();

        $data = $this->factoryMake()->toArray();

        $response = $this->post($this->routeToController(), $data + $this->action())
            ->assertStatus(200)
            ->assertJson([]);

        $this->dataVsRow($data, $this->rowLast(), $exclude, $only);

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
     * @param bool $vehicle = true
     * @param bool $device = true
     * @param array $exclude = []
     * @param array $only = []
     *
     * @return \Illuminate\Testing\TestResponse
     */
    public function postAuthCreateManagerSuccess(bool $vehicle = true, bool $device = true, array $exclude = [], array $only = []): TestResponse
    {
        $user1 = $this->authUserManager();

        [$vehicle1, $device1] = $this->createVehicleDeviceWithUser($user1, $vehicle, $device);

        [$user2, $vehicle2, $device2] = $this->createUserVehicleDevice($vehicle, $device);

        $data = $this->dataWithUserVehicleDeviceMake($user2, $vehicle2, $device2);

        $response = $this->post($this->routeToController(), $data + $this->action())
            ->assertStatus(200)
            ->assertJson([]);

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
     * @return \Illuminate\Testing\TestResponse
     */
    public function patchAuthUpdateSuccess(array $exclude = [], array $only = []): TestResponse
    {
        $this->authUser();

        $row = $this->factoryCreate();
        $data = $this->factoryMake()->toArray();

        $response = $this->patch(route($this->route, $row->id), $data + $this->action())
            ->assertStatus(200)
            ->assertJson([]);

        $this->dataVsRow($data, $this->rowLast(), $exclude, $only);

        return $response;
    }

    /**
     * @param bool $vehicle = true
     * @param bool $device = true
     *
     * @return \Illuminate\Testing\TestResponse
     */
    public function patchAuthUpdateAdminFail(bool $vehicle = true, bool $device = true): TestResponse
    {
        $user = $this->authUserAdmin();

        [$user, $row] = $this->createUserRow($user);

        $data = $this->dataWithUserVehicleDeviceMake($this->createUser());

        $response = $this->patch(route($this->route, $row->id), $data + $this->action())
            ->assertStatus(200)
            ->assertJson([]);

        $this->assertEquals($user->id, $this->rowLast()->user_id);

        return $response;
    }

    /**
     * @param array $exclude = []
     * @param array $only = []
     *
     * @return \Illuminate\Testing\TestResponse
     */
    public function patchAuthUpdateAdminSuccess(array $exclude = [], array $only = []): TestResponse
    {
        $this->authUserAdmin();

        $row = $this->factoryCreate();
        $data = $this->factoryMake()->toArray();

        $response = $this->patch(route($this->route, $row->id), $data + $this->action())
            ->assertStatus(200)
            ->assertJson([]);

        $this->dataVsRow($data, $this->rowLast(), $exclude, $only);

        return $response;
    }

    /**
     * @param bool $vehicle = true
     * @param bool $device = true
     *
     * @return \Illuminate\Testing\TestResponse
     */
    public function patchAuthUpdateManagerFail(bool $vehicle = true, bool $device = true): TestResponse
    {
        $user1 = $this->authUserManager();

        [$vehicle1, $device1, $row1] = $this->createVehicleDeviceRowWithUser($user1, $vehicle, $device);
        [$user2, $vehicle2, $device2] = $this->createUserVehicleDevice($vehicle, $device);

        $data = $this->dataWithUserVehicleDeviceMake($user2, $vehicle2, $device2);

        return $this->patch(route($this->route, $row1->id), $data + $this->action())
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
    public function patchAuthUpdateManagerSuccess(bool $vehicle = true, bool $device = true, array $exclude = [], array $only = []): TestResponse
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

        $response = $this->patch(route($this->route, $row2->id), $data + $this->action())
            ->assertStatus(200)
            ->assertJson([]);

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
    public function patchAuthUpdateManagerNoUserSuccess(array $exclude = [], array $only = []): TestResponse
    {
        $user1 = $this->authUserManager();

        [$user1, $row1] = $this->createUserRow($user1);
        [$user2, $row2] = $this->createUserRow();

        $data = $this->factoryMake()->toArray();

        $response = $this->patch(route($this->route, $row1->id), $data + $this->action())
            ->assertStatus(200)
            ->assertJson([]);

        $row1 = $this->rowFresh($row1);

        $this->assertEquals($user1->id, $row1->user_id, '$user1->id, $row1->user_id');

        $this->dataVsRow(['user_id' => $row1->user_id] + $data, $row1, $exclude, $only);

        $data = $this->factoryMake()->toArray();

        $response = $this->patch(route($this->route, $row2->id), $data + $this->action())
            ->assertStatus(200)
            ->assertJson([]);

        $row2 = $this->rowFresh($row2);

        $this->assertEquals($user2->id, $row2->user_id, '$user2->id, $row2->user_id');

        $this->dataVsRow(['user_id' => $row2->user_id] + $data, $row2, $exclude, $only);

        return $response;
    }

    /**
     * @return \Illuminate\Testing\TestResponse
     */
    public function deleteGuestFail(): TestResponse
    {
        return $this->delete($this->routeToController())
            ->assertNoContent(401);
    }

    /**
     * @return \Illuminate\Testing\TestResponse
     */
    public function deleteAuthFail(): TestResponse
    {
        $this->authUser();

        [$user2, $row2] = $this->createUserRow();

        return $this->delete(route($this->route, $row2->id))
            ->assertStatus(404)
            ->assertJsonStructure(['code', 'status', 'message', 'details']);
    }

    /**
     * @return \Illuminate\Testing\TestResponse
     */
    public function deleteAuthSuccess(): TestResponse
    {
        $this->authUser();

        return $this->delete($this->routeToController())
            ->assertNoContent(200);
    }

    /**
     * @return \Illuminate\Testing\TestResponse
     */
    public function deleteAuthAdminSuccess(): TestResponse
    {
        $this->authUserAdmin();

        return $this->delete($this->routeToController())
            ->assertNoContent(200);
    }

    /**
     * @return \Illuminate\Testing\TestResponse
     */
    public function deleteAuthAdminFail(): TestResponse
    {
        $this->authUserAdmin();

        $this->delete($this->routeToController())
            ->assertNoContent(200);

        [$user2, $row2] = $this->createUserRow();

        return $this->delete(route($this->route, $row2->id))
            ->assertStatus(404)
            ->assertJsonStructure(['code', 'status', 'message', 'details']);
    }

    /**
     * @return \Illuminate\Testing\TestResponse
     */
    public function deleteAuthManagerSuccess(): TestResponse
    {
        $this->authUserManager();

        $this->delete($this->routeToController())
            ->assertNoContent(200);

        [$user2, $row2] = $this->createUserRow();

        return $this->delete(route($this->route, $row2->id))
            ->assertNoContent(200);
    }

    /**
     * @return \Illuminate\Testing\TestResponse
     */
    public function deleteAuthAdminManagerSuccess(): TestResponse
    {
        $this->authUserAdminManager();

        $this->delete($this->routeToController())
            ->assertNoContent(200);

        [$user2, $row2] = $this->createUserRow();

        return $this->delete(route($this->route, $row2->id))
            ->assertNoContent(200);
    }
}
