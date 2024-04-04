<?php declare(strict_types=1);

namespace App\Domains\User\Test\ControllerApi;

class Update extends ControllerApiAbstract
{
    /**
     * @var string
     */
    protected string $route = 'api.user.update';

    /**
     * @return void
     */
    public function testGetGuestNotAllowedFail(): void
    {
        $this->getGuestNotAllowedFail();
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
        $this->postAuthAdminNotAllowedFail();
    }

    /**
     * @return void
     */
    public function testPostAuthAdminUpdateSuccess(): void
    {
        $this->authUserAdmin();

        $data = $this->factoryMake()->toArray();
        $data['password'] = $data['email'];

        $this->patch($this->routeToController(), $data)
            ->assertStatus(200)
            ->assertJson([]);

        $this->dataVsRow($data, $this->rowLast(), ['password', 'telegram']);
    }

    /**
     * @return string
     */
    protected function routeToController(): string
    {
        return $this->routeFactoryCreateModel();
    }
}
