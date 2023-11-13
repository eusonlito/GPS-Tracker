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
    public function testgetGuestUnauthorizedFail(): void
    {
        $this->getGuestUnauthorizedFail();
    }

    /**
     * @return void
     */
    public function testpostGuestUnauthorizedFail(): void
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
    public function testgetAuthSuccess(): void
    {
        $this->createVehicle();
        $this->getAuthSuccess();
    }

    /**
     * @return void
     */
    public function testpostAuthSuccess(): void
    {
        $this->createVehicle();
        $this->postAuthSuccess();
    }

    /**
     * @return void
     */
    public function testgetAuthAdminSuccess(): void
    {
        $this->createVehicle();
        $this->getAuthAdminSuccess();
    }

    /**
     * @return void
     */
    public function testpostAuthAdminSuccess(): void
    {
        $this->createVehicle();
        $this->postAuthAdminSuccess();
    }

    /**
     * @return void
     */
    public function testpostAuthCreateSuccess(): void
    {
        $this->createVehicle();
        $this->postAuthCreateSuccess();
    }

    /**
     * @return void
     */
    public function testgetAuthCreateAdminSuccess(): void
    {
        $this->createVehicle();
        $this->getAuthCreateAdminSuccess(device: false);
    }

    /**
     * @return void
     */
    public function testpostAuthCreateAdminFail(): void
    {
        $this->createVehicle();
        $this->postAuthCreateAdminFail(device: false);
    }

    /**
     * @return void
     */
    public function testpostAuthCreateAdminSuccess(): void
    {
        $this->createVehicle();
        $this->postAuthCreateAdminSuccess();
    }

    /**
     * @return void
     */
    public function testgetAuthCreateManagerSuccess(): void
    {
        $this->createVehicle();
        $this->getAuthCreateManagerSuccess(device: false);
    }

    /**
     * @return void
     */
    public function testpostAuthCreateManagerFail(): void
    {
        $this->createVehicle();
        $this->postAuthCreateManagerFail(device: false);
    }

    /**
     * @return void
     */
    public function testpostAuthCreateManagerSuccess(): void
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
