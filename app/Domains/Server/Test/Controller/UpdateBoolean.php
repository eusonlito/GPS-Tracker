<?php declare(strict_types=1);

namespace App\Domains\Server\Test\Controller;

class UpdateBoolean extends ControllerAbstract
{
    /**
     * @var string
     */
    protected string $route = 'server.update.boolean';

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
    public function testGetGuestFail(): void
    {
        $this->post($this->routeToController())
            ->assertStatus(302)
            ->assertRedirect(route('user.auth.credentials'));
    }

    /**
     * @return void
     */
    public function testGetAuthUnauthorizedFail(): void
    {
        $this->authUser();

        $this->get($this->routeToController())
            ->assertStatus(404);
    }

    /**
     * @return void
     */
    public function testPostAuthUnauthorizedFail(): void
    {
        $this->authUser();

        $this->post($this->routeToController())
            ->assertStatus(404);
    }

    /**
     * @return void
     */
    public function testGetAuthInvalidFail(): void
    {
        $this->authUserAdmin();

        $this->get($this->routeFactoryCreateModel(null, 'invalid'))
            ->assertStatus(422);
    }

    /**
     * @return void
     */
    public function testPostAuthInvalidFail(): void
    {
        $this->authUserAdmin();

        $this->post($this->routeFactoryCreateModel(null, 'invalid'))
            ->assertStatus(422);
    }

    /**
     * @return void
     */
    public function testGetAuthEmptySuccess(): void
    {
        $this->authUserAdmin();

        $this->get($this->routeToController())
            ->assertStatus(200);
    }

    /**
     * @return void
     */
    public function testGetAuthSuccess(): void
    {
        $this->authUserAdmin();
        $this->factoryCreate();

        $this->get($this->routeToController())
            ->assertStatus(200);
    }

    /**
     * @return void
     */
    public function testPostAuthEmptySuccess(): void
    {
        $this->authUserAdmin();

        $this->post($this->routeToController())
            ->assertStatus(200);
    }

    /**
     * @return void
     */
    public function testPostAuthSuccess(): void
    {
        $this->authUserAdmin();
        $this->factoryCreate();

        $this->post($this->routeToController())
            ->assertStatus(200);
    }

    /**
     * @return string
     */
    protected function routeToController(): string
    {
        return $this->routeFactoryCreateModel(null, 'enabled');
    }
}
