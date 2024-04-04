<?php declare(strict_types=1);

namespace App\Domains\User\Test\ControllerApi;

class Index extends ControllerApiAbstract
{
    /**
     * @var string
     */
    protected string $route = 'api.user.index';

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
    public function testGetAuthUnauthorizedFail(): void
    {
        $this->getAuthUnauthorizedFail();
    }

    /**
     * @return void
     */
    public function testGetAuthManagerFail(): void
    {
        $this->getAuthManagerFail();
    }

    /**
     * @return void
     */
    public function testGetAuthAdminSuccess(): void
    {
        $this->getAuthAdminSuccess();
    }

    /**
     * @return void
     */
    public function testGetAuthListAdminSuccess(): void
    {
        $row1 = $this->authUserAdmin();

        $this->get($this->routeToController())
            ->assertStatus(200)
            ->assertJson([])
            ->assertSeeText($row1->name);

        $row2 = $this->factoryCreate();

        $this->get($this->routeToController())
            ->assertStatus(200)
            ->assertJson([])
            ->assertSeeText($row1->name)
            ->assertSeeText($row2->name);
    }

    /**
     * @return string
     */
    protected function routeToController(): string
    {
        return $this->route();
    }
}
