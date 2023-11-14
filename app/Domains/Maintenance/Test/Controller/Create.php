<?php declare(strict_types=1);

namespace App\Domains\Maintenance\Test\Controller;

class Create extends ControllerAbstract
{
    /**
     * @var string
     */
    protected string $route = 'maintenance.create';

    /**
     * @var string
     */
    protected string $action = 'create';

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
    public function testGetAuthAdminSuccess(): void
    {
        $this->createVehicle();
        $this->getAuthAdminSuccess();
    }

    /**
     * @return void
     */
    public function testPostAuthAdminSuccess(): void
    {
        $this->createVehicle();
        $this->postAuthAdminSuccess();
    }

    /**
     * @return void
     */
    public function testPostAuthCreateSuccess(): void
    {
        $this->createVehicle();
        $this->postAuthCreateSuccess();
    }

    /**
     * @return void
     */
    public function testGetAuthCreateAdminSuccess(): void
    {
        $this->createVehicle();
        $this->getAuthCreateAdminSuccess(device: false);
    }

    /**
     * @return void
     */
    public function testPostAuthCreateAdminFail(): void
    {
        $this->createVehicle();
        $this->postAuthCreateAdminFail(device: false);
    }

    /**
     * @return void
     */
    public function testPostAuthCreateAdminSuccess(): void
    {
        $this->createVehicle();
        $this->postAuthCreateAdminSuccess();
    }

    /**
     * @return void
     */
    public function testGetAuthCreateManagerSuccess(): void
    {
        $this->createVehicle();
        $this->getAuthCreateManagerSuccess(device: false);
    }

    /**
     * @return void
     */
    public function testPostAuthCreateManagerFail(): void
    {
        $this->createVehicle();
        $this->postAuthCreateManagerFail(device: false);
    }

    /**
     * @return void
     */
    public function testPostAuthCreateManagerSuccess(): void
    {
        $this->createVehicle();
        $this->postAuthCreateManagerSuccess(device: false);
    }

    /**
     * @return string
     */
    protected function routeToController(): string
    {
        return $this->route();
    }
}
