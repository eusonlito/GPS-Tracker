<?php declare(strict_types=1);

namespace App\Domains\Dashboard\Test\Controller;

class Index extends ControllerAbstract
{
    /**
     * @var string
     */
    protected string $route = 'dashboard.index';

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
    public function testPostGuestNotAllowedFail(): void
    {
        $this->postGuestNotAllowedFail();
    }

    /**
     * @return void
     */
    public function testPostAuthNotAllowedFail(): void
    {
        $this->postAuthNotAllowedFail();
    }

    /**
     * @return void
     */
    public function testGetAuthSuccess(): void
    {
        $this->getAuthSuccess();
    }

    /**
     * @return void
     */
    public function testGetAuthAdminSuccess(): void
    {
        $this->getAuthAdminSuccess();
    }

    /**
     * @return void
     */
    public function testGetAuthListSuccess(): void
    {
        $this->getAuthListSuccess();
    }

    /**
     * @return void
     */
    public function testGetAuthListOnlyOwnSucess(): void
    {
        [
            $user1,
            $user2,
            $vehicle1,
            $vehicle2,
            $device1,
            $device2,
            $row1,
            $row2
        ] = $this->createUsersVehiclesDevicesTrips();

        $this->auth($user1);

        $response = $this->get($this->routeToController().'?vehicle_id=&device_id=')
            ->assertStatus(200)
            ->assertSeeText($row1->name)
            ->assertDontSeeText($row2->name)
            ->assertDontSeeText($user2->name);

        $response->assertSeeText($vehicle1->name);
        $response->assertDontSeeText($vehicle2->name);

        $response->assertSeeText($device1->name);
        $response->assertDontSeeText($device2->name);

        $this->auth($user2);

        $this->get($this->routeToController().'?vehicle_id=&device_id=')
            ->assertStatus(200)
            ->assertSeeText($row2->name)
            ->assertDontSeeText($row1->name)
            ->assertSeeText($vehicle2->name)
            ->assertDontSeeText($vehicle1->name)
            ->assertSeeText($device2->name)
            ->assertDontSeeText($device1->name);
    }

    /**
     * @return void
     */
    public function testGetAuthListAdminSuccess(): void
    {
        [
            $user1,
            $user2,
            $vehicle1,
            $vehicle2,
            $device1,
            $device2,
            $row1,
            $row2
        ] = $this->createUsersVehiclesDevicesTrips();

        $user1->admin = true;
        $user1->admin_mode = true;
        $user1->manager = false;
        $user1->manager_mode = false;
        $user1->save();

        $this->auth($user1);

        $this->get($this->routeToController().'?user_id=&vehicle_id=&device_id=')
            ->assertStatus(200)
            ->assertSeeText($row1->name)
            ->assertDontSeeText($row2->name)
            ->assertDontSeeText($user2->name)
            ->assertSeeText($vehicle1->name)
            ->assertDontSeeText($vehicle2->name)
            ->assertSeeText($device1->name)
            ->assertDontSeeText($device2->name);
    }

    /**
     * @return void
     */
    public function testGetAuthListManagerSuccess(): void
    {
        [
            $user1,
            $user2,
            $vehicle1,
            $vehicle2,
            $device1,
            $device2,
            $row1,
            $row2
        ] = $this->createUsersVehiclesDevicesTrips();

        $user1->admin = false;
        $user1->admin_mode = false;
        $user1->manager = true;
        $user1->manager_mode = true;
        $user1->save();

        $this->auth($user1);

        $this->get($this->routeToController().'?user_id=&vehicle_id=&device_id=')
            ->assertStatus(200)
            ->assertSeeText($row1->name)
            ->assertDontSeeText($row2->name)
            ->assertSeeText($user1->name)
            ->assertSeeText($user2->name)
            ->assertSeeText($vehicle1->name)
            ->assertDontSeeText($vehicle2->name)
            ->assertSeeText($device1->name)
            ->assertDontSeeText($device2->name);

        $this->get($this->routeToController().'?user_id='.$user2->id.'&vehicle_id=&device_id=')
            ->assertStatus(200)
            ->assertDontSeeText($row1->name)
            ->assertSeeText($row2->name)
            ->assertSeeText($user1->name)
            ->assertSeeText($user2->name)
            ->assertDontSeeText($vehicle1->name)
            ->assertSeeText($vehicle2->name)
            ->assertDontSeeText($device1->name)
            ->assertSeeText($device2->name);
    }

    /**
     * @return array
     */
    protected function createUsersVehiclesDevicesTrips(): array
    {
        $user1 = $this->createUser();
        $user2 = $this->createUser();

        $user1_vehicle1 = $this->createVehicle($user1);
        $user1_vehicle2 = $this->createVehicle($user1);

        $user2_vehicle1 = $this->createVehicle($user2);
        $user2_vehicle2 = $this->createVehicle($user2);

        $user1_vehicle1_device1 = $this->createDevice($user1_vehicle1);
        $user1_vehicle1_device2 = $this->createDevice($user1_vehicle1);
        $user1_vehicle2_device1 = $this->createDevice($user1_vehicle2);
        $user1_vehicle2_device2 = $this->createDevice($user1_vehicle2);

        $user2_vehicle1_device1 = $this->createDevice($user2_vehicle1);
        $user2_vehicle1_device2 = $this->createDevice($user2_vehicle1);
        $user2_vehicle2_device1 = $this->createDevice($user2_vehicle2);
        $user2_vehicle2_device2 = $this->createDevice($user2_vehicle2);

        $user1_vehicle2->name = 'ZZ'.$user1_vehicle2->name;
        $user1_vehicle2->save();

        $user2_vehicle2->name = 'ZZ'.$user2_vehicle2->name;
        $user2_vehicle2->save();

        $user1_vehicle1_device2->name = 'ZZ'.$user1_vehicle1_device2->name;
        $user1_vehicle1_device2->save();
        $user1_vehicle2_device1->name = 'ZZ'.$user1_vehicle2_device1->name;
        $user1_vehicle2_device1->save();
        $user1_vehicle2_device2->name = 'ZZ'.$user1_vehicle2_device2->name;
        $user1_vehicle2_device2->save();

        $user2_vehicle1_device2->name = 'ZZ'.$user2_vehicle1_device2->name;
        $user2_vehicle1_device2->save();
        $user2_vehicle2_device1->name = 'ZZ'.$user2_vehicle2_device1->name;
        $user2_vehicle2_device1->save();
        $user2_vehicle2_device2->name = 'ZZ'.$user2_vehicle2_device2->name;
        $user2_vehicle2_device2->save();

        $this->createRowWithUserVehicleDevice($user1, $user1_vehicle1, $user1_vehicle1_device1);
        $this->createRowWithUserVehicleDevice($user1, $user1_vehicle1, $user1_vehicle1_device2);
        $this->createRowWithUserVehicleDevice($user1, $user1_vehicle2, $user1_vehicle2_device1);

        $this->createRowWithUserVehicleDevice($user2, $user2_vehicle1, $user2_vehicle1_device1);
        $this->createRowWithUserVehicleDevice($user2, $user2_vehicle1, $user2_vehicle1_device2);
        $this->createRowWithUserVehicleDevice($user2, $user2_vehicle2, $user2_vehicle2_device1);

        return [
            $user1,
            $user2,
            $user1_vehicle1,
            $user2_vehicle1,
            $user1_vehicle1_device1,
            $user2_vehicle1_device1,
            $this->createRowWithUserVehicleDevice($user1, $user1_vehicle1, $user1_vehicle1_device1),
            $this->createRowWithUserVehicleDevice($user2, $user2_vehicle1, $user2_vehicle1_device1),
        ];
    }

    /**
     * @return string
     */
    protected function routeToController(): string
    {
        return $this->route();
    }
}
