<?php declare(strict_types=1);

namespace App\Domains\User\Test\Controller;

class Logout extends ControllerAbstract
{
    /**
     * @var string
     */
    protected string $route = 'user.logout';

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
    public function testPostGuestNotAllowedFail(): void
    {
        $this->postGuestNotAllowedFail();
    }

    /**
     * @return void
     */
    public function testPostAuthNotAllowedFail(): void
    {
        $this->postAuthNotAllowedFail();
    }

    /**
     * @return void
     */
    public function testGetAuthSuccess(): void
    {
        $this->authUser();

        $this->get($this->routeToController())
            ->assertStatus(302)
            ->assertRedirect(route('user.auth.credentials'));
    }

    /**
     * @return string
     */
    protected function routeToController(): string
    {
        return $this->route();
    }
}
