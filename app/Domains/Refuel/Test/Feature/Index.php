<?php declare(strict_types=1);

namespace App\Domains\Refuel\Test\Feature;

use App\Domains\Vehicle\Model\Vehicle as VehicleModel;

class Index extends FeatureAbstract
{
    /**
     * @var string
     */
    protected string $route = 'refuel.index';

    /**
     * @return void
     */
    public function testGetUnauthorizedFail(): void
    {
        $this->get($this->route())
            ->assertStatus(302)
            ->assertRedirect(route('user.auth.credentials'));
    }

    /**
     * @return void
     */
    public function testPostUnauthorizedFail(): void
    {
        $this->post($this->route())
            ->assertStatus(405);
    }

    /**
     * @return void
     */
    public function testGetEmptyNoVehicleFail(): void
    {
        $this->authUser();

        $this->get($this->route())
            ->assertStatus(302);
    }

    /**
     * @return void
     */
    public function testGetEmptySuccess(): void
    {
        $this->authUser();
        $this->factoryCreateModel(VehicleModel::class);

        $this->get($this->route())
            ->assertStatus(200);
    }

    /**
     * @return void
     */
    public function testGetSuccess(): void
    {
        $this->authUser();
        $this->factoryCreateModel(VehicleModel::class);
        $this->factoryCreateModel();

        $this->get($this->route())
            ->assertStatus(200);
    }
}
