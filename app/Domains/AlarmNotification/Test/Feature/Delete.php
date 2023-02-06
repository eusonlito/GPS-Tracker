<?php declare(strict_types=1);

namespace App\Domains\AlarmNotification\Test\Feature;

use App\Domains\AlarmNotification\Model\AlarmNotification as Model;

class Delete extends FeatureAbstract
{
    /**
     * @var string
     */
    protected string $route = 'alarm-notification.delete';

    /**
     * @return void
     */
    public function testGetUnauthorizedFail(): void
    {
        $this->get($this->routeFactoryCreateModel())
            ->assertStatus(302)
            ->assertRedirect(route('user.auth.credentials'));
    }

    /**
     * @return void
     */
    public function testPostUnauthorizedFail(): void
    {
        $this->post($this->routeFactoryCreateModel())
            ->assertStatus(302)
            ->assertRedirect(route('user.auth.credentials'));
    }

    /**
     * @return void
     */
    public function testGetSuccess(): void
    {
        $this->authUser();

        $route = $this->routeFactoryCreateModel();

        $this->assertEquals(Model::count(), 1);

        $this->get($route)
            ->assertStatus(302);

        $this->assertEquals(Model::count(), 0);
    }

    /**
     * @return void
     */
    public function testPostSuccess(): void
    {
        $this->authUser();

        $route = $this->routeFactoryCreateModel();

        $this->assertEquals(Model::count(), 1);

        $this->post($route)
            ->assertStatus(302);

        $this->assertEquals(Model::count(), 0);
    }
}
