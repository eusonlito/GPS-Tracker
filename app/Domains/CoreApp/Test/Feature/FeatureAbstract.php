<?php declare(strict_types=1);

namespace App\Domains\CoreApp\Test\Feature;

use App\Domains\Core\Test\Feature\FeatureAbstract as FeatureAbstractCore;
use App\Domains\Device\Model\Device as DeviceModel;
use App\Domains\User\Model\User as UserModel;
use App\Domains\Vehicle\Model\Vehicle as VehicleModel;

abstract class FeatureAbstract extends FeatureAbstractCore
{
    /**
     * @return array
     */
    protected function createUserVehicleDevice(): array
    {
        $user = $this->factoryCreate(UserModel::class);
        $vehicle = $this->factoryCreate(VehicleModel::class, ['user_id' => $user->id]);
        $device = $this->factoryCreate(DeviceModel::class, ['user_id' => $user->id, 'vehicle_id' => $vehicle->id]);

        return [$user, $vehicle, $device];
    }

    /**
     * @return void
     */
    public function getGuestUnauthorizedFail(): void
    {
        $this->get($this->routeToController())
            ->assertStatus(302)
            ->assertRedirect(route('user.auth.credentials'));
    }

    /**
     * @return void
     */
    public function postGuestNotAllowedFail(): void
    {
        $this->post($this->routeToController())
            ->assertStatus(405);
    }

    /**
     * @return void
     */
    public function postAuthNotAllowedFail(): void
    {
        $this->authUser();

        $this->post($this->routeToController())
            ->assertStatus(405);
    }

    /**
     * @return void
     */
    public function getAuthEmptySuccess(): void
    {
        $this->authUser();

        $this->get($this->routeToController())
            ->assertStatus(200);
    }

    /**
     * @param string $name = 'name'
     *
     * @return void
     */
    public function getAuthSuccess(string $name = 'name'): void
    {
        $this->authUser();

        $row = $this->factoryCreate();

        $this->get($this->routeToController())
            ->assertStatus(200)
            ->assertSee($row->$name);
    }

    /**
     * @param string $name = 'name'
     *
     * @return void
     */
    public function getAuthOnlyOwn(string $name = 'name'): void
    {
        $this->createTwoUsers();

        $one = $this->factoryCreate(data: ['user_id' => 1]);
        $two = $this->factoryCreate(data: ['user_id' => 2]);

        $this->authUser(1);

        $this->get($this->routeToController())
            ->assertStatus(200)
            ->assertSeeText($one->$name)
            ->assertDontSeeText($two->$name);

        $this->authUser(2);

        $this->get($this->routeToController())
            ->assertStatus(200)
            ->assertSeeText($two->$name)
            ->assertDontSeeText($one->$name);
    }
}
