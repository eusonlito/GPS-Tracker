<?php declare(strict_types=1);

namespace App\Domains\Alarm\Test\Feature;

class UpdateBoolean extends FeatureAbstract
{
    /**
     * @var string
     */
    protected string $route = 'alarm.update.boolean';

    /**
     * @return void
     */
    public function testGetUnauthorizedFail(): void
    {
        $this->get($this->routeFactoryCreateModelId('enabled'))
            ->assertStatus(302)
            ->assertRedirect(route('user.auth.credentials'));
    }

    /**
     * @return void
     */
    public function testPostUnauthorizedFail(): void
    {
        $this->post($this->routeFactoryCreateModelId('enabled'))
            ->assertStatus(302)
            ->assertRedirect(route('user.auth.credentials'));
    }

    /**
     * @return void
     */
    public function testGetInvalidFail(): void
    {
        $this->authUser();

        $this->get($this->routeFactoryCreateModelId('invalid'))
            ->assertStatus(422);
    }

    /**
     * @return void
     */
    public function testPostInvalidFail(): void
    {
        $this->authUser();

        $this->post($this->routeFactoryCreateModelId('invalid'))
            ->assertStatus(422);
    }

    /**
     * @return void
     */
    public function testGetSuccess(): void
    {
        $this->authUser();

        $this->get($this->routeFactoryCreateModelId('enabled'))
            ->assertStatus(200);
    }

    /**
     * @return void
     */
    public function testPostSuccess(): void
    {
        $this->authUser();

        $this->post($this->routeFactoryCreateModelId('enabled'))
            ->assertStatus(200);
    }
}
