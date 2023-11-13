<?php declare(strict_types=1);

namespace App\Domains\Device\Test\Controller;

class Update extends ControllerAbstract
{
    /**
     * @var string
     */
    protected string $route = 'device.update';

    /**
     * @var string
     */
    protected string $action = 'update';

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
    public function testGetAuthSuccess(): void
    {
        $this->getAuthSuccess();
    }

    /**
     * @return void
     */
    public function testPostAuthSuccess(): void
    {
        $this->postAuthSuccess();
    }

    /**
     * @return void
     */
    public function testGetAuthSharedSuccess(): void
    {
        $this->authUser();
        $this->factoryCreate(data: [
            'shared' => true,
            'shared_public' => true,
        ]);

        $this->get($this->routeFactoryLastModel())
            ->assertStatus(200);
    }

    /**
     * @return void
     */
    public function testPostAuthUpdateSuccess(): void
    {
        $this->postAuthUpdateSuccess(['connected_at']);
    }

    /**
     * @return void
     */
    public function testGetAuthUpdateAdminSuccess(): void
    {
        $this->getAuthUpdateAdminSuccess();
    }

    /**
     * @return void
     */
    public function testGetAuthUpdateManagerSuccess(): void
    {
        $this->getAuthUpdateManagerSuccess(vehicle: true, device: false);
    }

    /**
     * @return void
     */
    public function testPostAuthUpdateManagerSuccess(): void
    {
        $this->postAuthUpdateManagerSuccess(vehicle: true, device: false, exclude: ['connected_at']);
    }

    /**
     * @return string
     */
    protected function routeToController(): string
    {
        return $this->routeFactoryCreateModel();
    }
}
