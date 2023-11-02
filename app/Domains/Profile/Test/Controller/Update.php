<?php declare(strict_types=1);

namespace App\Domains\Profile\Test\Controller;

class Update extends ControllerAbstract
{
    /**
     * @var string
     */
    protected string $route = 'profile.update';

    /**
     * @var string
     */
    protected string $action = 'update';

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
    public function testGetAuthSuccess(): void
    {
        $this->getAuthSuccess();
    }

    /**
     * @return void
     */
    public function testPostAuthSuccess(): void
    {
        $user = $this->authUser();

        $data = $this->factoryMake()->toArray();
        $data['password_current'] = $user->email;

        $this->post($this->routeToController(), $data + $this->action())
            ->assertStatus(302)
            ->assertRedirect($this->routeToController());

        $this->dataVsRow($data, $user, ['password_current']);
    }

    /**
     * @return string
     */
    protected function routeToController(): string
    {
        return $this->route();
    }
}
