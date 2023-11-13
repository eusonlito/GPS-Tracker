<?php declare(strict_types=1);

namespace App\Domains\Maintenance\Test\Controller;

class Index extends ControllerAbstract
{
    /**
     * @var string
     */
    protected string $route = 'maintenance.index';

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
    public function testGetAuthListSuccess(): void
    {
        $this->createVehicle();
        $this->getAuthListSuccess();
    }

    /**
     * @return void
     */
    public function testGetAuthListOnlyOwnSucess(): void
    {
        $this->createVehicle();
        $this->getAuthListOnlyOwnSucess(device: false);
    }

    /**
     * @return void
     */
    public function testGetAuthListAdminSuccess(): void
    {
        $this->createVehicle();
        $this->getAuthListAdminSuccess(device: false);
    }

    /**
     * @return void
     */
    public function testGetAuthListManagerSuccess(): void
    {
        $this->createVehicle();
        $this->getAuthListManagerSuccess(device: false);
    }

    /**
     * @return string
     */
    protected function routeToController(): string
    {
        return $this->route();
    }
}
