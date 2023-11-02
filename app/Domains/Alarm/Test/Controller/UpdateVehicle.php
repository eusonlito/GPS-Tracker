<?php declare(strict_types=1);

namespace App\Domains\Alarm\Test\Controller;

class UpdateVehicle extends ControllerAbstract
{
    /**
     * @var string
     */
    protected string $route = 'alarm.update.vehicle';

    /**
     * @var string
     */
    protected string $action = 'updateVehicle';

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
     * @return string
     */
    protected function routeToController(): string
    {
        return $this->routeFactoryCreateModel();
    }
}
