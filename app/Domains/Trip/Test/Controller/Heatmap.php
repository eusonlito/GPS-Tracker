<?php declare(strict_types=1);

namespace App\Domains\Trip\Test\Controller;

class Heatmap extends ControllerAbstract
{
    /**
     * @var string
     */
    protected string $route = 'trip.heatmap';

    /**
     * @return void
     */
    public function testGetGuestUnauthorizedFail(): void
    {
        $this->getGuestUnauthorizedFail();
    }

    /**
     * @return void
     */
    public function testPostGuestUnauthorizedFail(): void
    {
        $this->postGuestUnauthorizedFail();
    }

    /**
     * @return void
     */
    public function testGetAuthNoVehicleFail(): void
    {
        $this->authUser();

        $this->get($this->routeToController())
            ->assertStatus(302)
            ->assertRedirect(route('vehicle.create'));
    }

    /**
     * @return void
     */
    public function testGetAuthSuccess(): void
    {
        $this->createVehicle();
        $this->getAuthSuccess();
    }

    /**
     * @return void
     */
    public function testPostAuthSuccess(): void
    {
        $this->createVehicle();
        $this->postAuthSuccess();
    }

    /**
     * @return void
     */
    public function testGetAuthListSuccess(): void
    {
        $this->createVehicle();
        $this->authUser();

        $row = $this->factoryCreate();

        $this->get($this->routeToController())
            ->assertStatus(200);
    }

    /**
     * @return void
     */
    public function testGetAuthListOnlyOwnSucess(): void
    {
        $user1 = $this->authUser();
        $user2 = $this->createUser();

        [$vehicle1, $device1, $row1] = $this->createVehicleDeviceRowWithUser($user1, true, false);
        [$vehicle2, $device2, $row2] = $this->createVehicleDeviceRowWithUser($user2, true, false);

        $this->get($this->routeToController().'?vehicle_id=&device_id=')
            ->assertStatus(200)
            ->assertDontSeeText($user1->name)
            ->assertDontSeeText($user2->name)
            ->assertDontSeeText($vehicle1->name)
            ->assertDontSeeText($vehicle2->name);

        $this->auth($user2);

        $this->get($this->routeToController().'?vehicle_id=&device_id=')
            ->assertStatus(200)
            ->assertDontSeeText($user2->name)
            ->assertDontSeeText($user1->name)
            ->assertDontSeeText($vehicle2->name)
            ->assertDontSeeText($vehicle1->name);

        $this->auth($user1);

        [$vehicle1, $device1, $row1] = $this->createVehicleDeviceRowWithUser($user1, true, false);
        [$vehicle2, $device2, $row2] = $this->createVehicleDeviceRowWithUser($user2, true, false);

        $this->get($this->routeToController().'?vehicle_id=&device_id=')
            ->assertStatus(200)
            ->assertDontSeeText($user2->name)
            ->assertSeeText($vehicle1->name)
            ->assertDontSeeText($vehicle2->name);

        $this->auth($user2);

        $this->get($this->routeToController().'?vehicle_id=&device_id=')
            ->assertStatus(200)
            ->assertDontSeeText($user2->name)
            ->assertSeeText($vehicle2->name)
            ->assertDontSeeText($vehicle1->name);
    }

    /**
     * @return void
     */
    public function testGetAuthListAdminSuccess(): void
    {
        $user1 = $this->authUserAdmin();
        $user2 = $this->createUser();

        [$vehicle1, $device1, $row1] = $this->createVehicleDeviceRowWithUser($user1, true, false);
        [$vehicle2, $device2, $row2] = $this->createVehicleDeviceRowWithUser($user2, true, false);

        $this->get($this->routeToController().'?user_id=&vehicle_id=&device_id=')
            ->assertStatus(200)
            ->assertDontSeeText($user2->name)
            ->assertDontSeeText($vehicle1->name)
            ->assertDontSeeText($vehicle2->name);

        [$vehicle1, $device1, $row1] = $this->createVehicleDeviceRowWithUser($user1, true, false);

        $this->get($this->routeToController().'?user_id=&vehicle_id=&device_id=')
            ->assertStatus(200)
            ->assertDontSeeText($user2->name)
            ->assertSeeText($vehicle1->name)
            ->assertDontSeeText($vehicle2->name);
    }

    /**
     * @return void
     */
    public function testGetAuthListManagerSuccess(): void
    {
        $user1 = $this->authUserManager();
        $user2 = $this->createUser();

        [$vehicle1, $device1, $row1] = $this->createVehicleDeviceRowWithUser($user1, true, false);
        [$vehicle2, $device2, $row2] = $this->createVehicleDeviceRowWithUser($user2, true, false);

        $response = $this->get($this->routeToController().'?user_id=&vehicle_id=&device_id=')
            ->assertStatus(200)
            ->assertSeeText($user1->name)
            ->assertSeeText($user2->name)
            ->assertSeeText($vehicle1->name)
            ->assertSeeText($vehicle2->name);

        $response = $this->get($this->routeToController().'?user_id='.$user2->id.'&vehicle_id=&device_id=')
            ->assertStatus(200)
            ->assertSeeText($user2->name)
            ->assertSeeText($user1->name)
            ->assertDontSeeText($vehicle2->name)
            ->assertDontSeeText($vehicle1->name);

        $this->createVehicleDeviceRowWithUser($user1, true, false);
        $this->createVehicleDeviceRowWithUser($user2, true, false);

        $response = $this->get($this->routeToController().'?user_id=&vehicle_id=&device_id=')
            ->assertStatus(200)
            ->assertSeeText($user1->name)
            ->assertSeeText($user2->name)
            ->assertSeeText($vehicle1->name)
            ->assertSeeText($vehicle2->name);

        $response = $this->get($this->routeToController().'?user_id='.$user2->id.'&vehicle_id=&device_id=')
            ->assertStatus(200)
            ->assertSeeText($user2->name)
            ->assertSeeText($user1->name)
            ->assertSeeText($vehicle2->name)
            ->assertDontSeeText($vehicle1->name);
    }

    /**
     * @return string
     */
    protected function routeToController(): string
    {
        return $this->route();
    }
}
