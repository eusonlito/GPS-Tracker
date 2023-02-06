<?php declare(strict_types=1);

namespace App\Domains\AlarmNotification\Test\Feature;

class Index extends FeatureAbstract
{
    /**
     * @var string
     */
    protected string $route = 'alarm-notification.index';

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
    public function testGetEmptySuccess(): void
    {
        $this->authUser();

        $this->get($this->route())
            ->assertStatus(200);
    }

    /**
     * @return void
     */
    public function testGetSuccess(): void
    {
        $this->authUser();
        $this->factoryCreateModel();

        $this->get($this->route())
            ->assertStatus(200);
    }
}
