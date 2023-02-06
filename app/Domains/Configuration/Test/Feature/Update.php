<?php declare(strict_types=1);

namespace App\Domains\Configuration\Test\Feature;

class Update extends FeatureAbstract
{
    /**
     * @var string
     */
    protected string $route = 'configuration.update';

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
    public function testGetUserFail(): void
    {
        $this->authUser();

        $this->get($this->routeFactoryCreateModel())
            ->assertStatus(404);
    }

    /**
     * @return void
     */
    public function testPostUserFail(): void
    {
        $this->authUser();

        $this->post($this->routeFactoryCreateModel())
            ->assertStatus(404);
    }

    /**
     * @return void
     */
    public function testGetSuccess(): void
    {
        $this->authUserAdmin();

        $this->get($this->routeFactoryCreateModel())
            ->assertStatus(200);
    }

    /**
     * @return void
     */
    public function testPostSuccess(): void
    {
        $this->authUserAdmin();

        $this->post($this->routeFactoryCreateModel())
            ->assertStatus(200);
    }
}
