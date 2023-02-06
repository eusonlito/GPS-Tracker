<?php declare(strict_types=1);

namespace App\Domains\Device\Test\Feature;

use App\Domains\DeviceMessage\Model\DeviceMessage as DeviceMessageModel;

class UpdateDeviceMessageUpdate extends FeatureAbstract
{
    /**
     * @var string
     */
    protected string $route = 'device.update.device-message.update';

    /**
     * @return void
     */
    public function testGetUnauthorizedFail(): void
    {
        $this->get($this->routeToController())
            ->assertStatus(302)
            ->assertRedirect(route('user.auth.credentials'));
    }

    /**
     * @return void
     */
    public function testPostUnauthorizedFail(): void
    {
        $this->post($this->routeToController())
            ->assertStatus(302)
            ->assertRedirect(route('user.auth.credentials'));
    }

    /**
     * @return void
     */
    public function testGetSuccess(): void
    {
        $this->authUser();

        $this->get($this->routeToController())
            ->assertStatus(302);
    }

    /**
     * @return void
     */
    public function testPostSuccess(): void
    {
        $this->authUser();

        $this->post($this->routeToController())
            ->assertStatus(302);
    }

    /**
     * @return string
     */
    protected function routeToController(): string
    {
        $row = $this->factoryCreateModel();
        $message = $this->factoryCreateModel(DeviceMessageModel::class);

        return $this->route(null, $row->id, $message->id);
    }
}
