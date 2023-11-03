<?php declare(strict_types=1);

namespace App\Domains\Profile\Test\Controller;

class UpdateTelegram extends ControllerAbstract
{
    /**
     * @var string
     */
    protected string $route = 'profile.update.telegram';

    /**
     * @var string
     */
    protected string $action = 'updateTelegramChatId';

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
        $this->setCurl();

        $user = $this->authUser();

        $data = $this->factoryMake()->toArray();
        $data['password_current'] = $user->email;

        $this->post($this->routeToController(), $data + $this->action())
            ->assertStatus(302)
            ->assertRedirect(route('dashboard.index'));
    }

    /**
     * @return string
     */
    protected function routeToController(): string
    {
        return $this->route();
    }

    /**
     * @return void
     */
    protected function setCurl(): void
    {
        $this->curlFake('resources/app/test/profile/api.telegram.org.log');
    }
}
