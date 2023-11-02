<?php declare(strict_types=1);

namespace App\Domains\Server\Test\Controller;

class UpdateParser extends ControllerAbstract
{
    /**
     * @var string
     */
    protected string $route = 'server.update.parser';

    /**
     * @var string
     */
    protected string $action = 'parse';

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

        $this->post($this->routeToController())
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

        $this->factoryCreate();

        $this->get($this->routeToController())
            ->assertStatus(200);
    }

    /**
     * @return void
     */
    public function testPostAuthAdminEmptyFail(): void
    {
        $this->authUserAdmin();

        $this->post($this->routeToController(), $this->action())
            ->assertStatus(422);
    }

    /**
     * @return void
     */
    public function testPostAuthAdminSuccess(): void
    {
        $this->authUserAdmin();

        $data = ['log' => '*#'];

        $this->post($this->routeToController(), $data + $this->action())
            ->assertStatus(200);
    }

    /**
     * @return string
     */
    protected function routeToController(): string
    {
        return $this->routeFactoryCreateModel();
    }
}
