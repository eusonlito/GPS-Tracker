<?php declare(strict_types=1);

namespace App\Domains\Alarm\Test\Feature;

class UpdateVehicle extends FeatureAbstract
{
    /**
     * @var string
     */
    protected string $route = 'alarm.update.vehicle';

    /**
     * @return void
     */
    public function testGetUnauthorizedFail(): void
    {
        $this->get($this->routeFactoryCreateModelId())
            ->assertStatus(302)
            ->assertRedirect(route('user.auth.credentials'));
    }

    /**
     * @return void
     */
    public function testPostUnauthorizedFail(): void
    {
        $this->post($this->routeFactoryCreateModelId())
            ->assertStatus(302)
            ->assertRedirect(route('user.auth.credentials'));
    }

    /**
     * @return void
     */
    public function testGetSuccess(): void
    {
        $this->authUser();

        $this->get($this->routeFactoryCreateModelId())
            ->assertStatus(200);
    }

    /**
     * @return void
     */
    public function testPostSuccess(): void
    {
        $this->authUser();

        $this->post($this->routeFactoryCreateModelId())
            ->assertStatus(200);
    }
}
