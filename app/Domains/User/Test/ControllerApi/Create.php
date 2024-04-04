<?php declare(strict_types=1);

namespace App\Domains\User\Test\ControllerApi;

class Create extends ControllerApiAbstract
{
    /**
     * @var string
     */
    protected string $route = 'api.user.create';

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
    public function testPostGuestUnauthorizedFail(): void
    {
        $this->postGuestUnauthorizedFail();
    }

    /**
     * @return void
     */
    public function testPostAuthManagerFail(): void
    {
        $this->postAuthManagerFail();
    }

    /**
     * @return void
     */
    public function testPostAuthCreateSuccess(): void
    {
        $this->authUserAdmin();

        $data = $this->factoryMake()->toArray();
        $data['password'] = $data['email'];

        $this->post($this->routeToController(), $data)
            ->assertStatus(200)
            ->assertJson([]);

        $this->dataVsRow($data, $this->rowLast(), ['password', 'telegram']);
    }

    /**
     * @return string
     */
    protected function routeToController(): string
    {
        return $this->route();
    }
}
