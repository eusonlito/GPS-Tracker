<?php declare(strict_types=1);

namespace App\Domains\User\Test\Controller;

class Index extends ControllerAbstract
{
    /**
     * @var string
     */
    protected string $route = 'user.index';

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
    public function testGetAuthUnauthorizedFail(): void
    {
        $this->getAuthUnauthorizedFail();
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
    public function testPostAuthAdminNotAllowedFail(): void
    {
        $this->authUserAdmin();

        $this->post($this->routeToController())
            ->assertStatus(405);
    }

    /**
     * @return void
     */
    public function testGetAuthAdminSuccess(): void
    {
        $this->authUserAdmin();

        $this->get($this->routeToController())
            ->assertStatus(200);

        $this->factoryCreate();

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
