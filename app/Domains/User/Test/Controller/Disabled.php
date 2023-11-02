<?php declare(strict_types=1);

namespace App\Domains\User\Test\Controller;

class Disabled extends ControllerAbstract
{
    /**
     * @var string
     */
    protected string $route = 'user.disabled';

    /**
     * @return void
     */
    public function testGetGuestUnauthorizedFail(): void
    {
        $this->getGuestUnauthorizedFail();
    }

    /**
     * @return void
     */
    public function testPostGuestUnauthorizedFail(): void
    {
        $this->postGuestUnauthorizedFail();
    }

    /**
     * @return void
     */
    public function testGetAuthEnabledFail(): void
    {
        $this->authUser();

        $this->get($this->routeToController())
            ->assertStatus(302)
            ->assertRedirect(route('dashboard.index'));
    }

    /**
     * @return void
     */
    public function testPostAuthEnabledFail(): void
    {
        $this->authUser();

        $this->post($this->routeToController())
            ->assertStatus(302)
            ->assertRedirect(route('dashboard.index'));
    }

    /**
     * @return void
     */
    public function testGetAuthSuccess(): void
    {
        $user = $this->authUser();
        $user->enabled = false;
        $user->save();

        $this->get($this->routeToController())
            ->assertStatus(200);
    }

    /**
     * @return void
     */
    public function testPostAuthSuccess(): void
    {
        $user = $this->authUser();
        $user->enabled = false;
        $user->save();

        $this->post($this->routeToController())
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
