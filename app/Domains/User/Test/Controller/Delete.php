<?php declare(strict_types=1);

namespace App\Domains\User\Test\Controller;

class Delete extends ControllerAbstract
{
    /**
     * @var string
     */
    protected string $route = 'user.update';

    /**
     * @var string
     */
    protected string $action = 'delete';

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
    public function testGetAuthUnauthorizedFail(): void
    {
        $this->getAuthUnauthorizedFail();
    }

    /**
     * @return void
     */
    public function testPostAuthUnauthorizedFail(): void
    {
        $this->authUser();

        $this->post($this->routeToController(), $this->action())
            ->assertStatus(404);
    }

    /**
     * @return void
     */
    public function testGetAuthAdminSuccess(): void
    {
        $this->authUserAdmin();

        $this->get($this->routeToController())
            ->assertStatus(200);
    }

    /**
     * @return void
     */
    public function testPostAuthAdminSuccess(): void
    {
        $this->postAuthAdminDeleteSuccess();
    }

    /**
     * @return string
     */
    protected function routeToController(): string
    {
        return $this->routeFactoryCreateModel();
    }
}
