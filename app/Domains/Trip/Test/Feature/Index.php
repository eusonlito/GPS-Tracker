<?php declare(strict_types=1);

namespace App\Domains\Trip\Test\Feature;

use App\Domains\Vehicle\Model\Vehicle as VehicleModel;

class Index extends FeatureAbstract
{
    /**
     * @var string
     */
    protected string $route = 'trip.index';

    /**
     * @return void
     */
    public function testGetGuestUnauthorizedFail(): void
    {
        $this->get($this->routeToController())
            ->assertStatus(302)
            ->assertRedirect(route('user.auth.credentials'));
    }

    /**
     * @return void
     */
    public function testPostGuestNotAllowedFail(): void
    {
        $this->post($this->routeToController())
            ->assertStatus(405);
    }

    /**
     * @return void
     */
    public function testPostAuthNotAllowedFail(): void
    {
        $this->authUser();

        $this->post($this->routeToController())
            ->assertStatus(405);
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
    public function testGetAuthEmptySuccess(): void
    {
        $this->authUser();
        $this->factoryCreate(VehicleModel::class);

        $this->get($this->routeToController())
            ->assertStatus(200);
    }

    /**
     * @return void
     */
    public function testGetAuthSuccess(): void
    {
        $this->authUser();
        $this->factoryCreate();
        $this->factoryCreate(VehicleModel::class);

        $this->get($this->routeToController())
            ->assertStatus(200);
    }

    /**
     * @return string
     */
    protected function routeToController(): string
    {
        return $this->route();
    }
}