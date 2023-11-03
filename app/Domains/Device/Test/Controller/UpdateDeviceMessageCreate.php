<?php declare(strict_types=1);

namespace App\Domains\Device\Test\Controller;

use App\Domains\DeviceMessage\Model\DeviceMessage as DeviceMessageModel;

class UpdateDeviceMessageCreate extends ControllerAbstract
{
    /**
     * @var string
     */
    protected string $route = 'device.update.device-message.create';

    /**
     * @var string
     */
    protected string $action = 'updateDeviceMessageCreate';

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
        $this->authUser();

        $this->get($this->routeToController())
            ->assertStatus(302)
            ->assertRedirect(route('dashboard.index'));
    }

    /**
     * @return void
     */
    public function testPostAuthSuccess(): void
    {
        $this->authUser();

        $data = $this->factoryMake(DeviceMessageModel::class)->toArray();

        $this->post($this->routeToController(), $data + $this->action())
            ->assertStatus(302)
            ->assertRedirect(route('dashboard.index'));
    }

    /**
     * @return string
     */
    protected function routeToController(): string
    {
        return $this->routeFactoryCreateModel();
    }
}
