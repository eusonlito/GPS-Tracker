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
        $this->postAuthUnauthorizedFail();
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
