<?php declare(strict_types=1);

namespace App\Domains\AlarmNotification\Test\Controller;

class UpdateClosedAt extends ControllerAbstract
{
    /**
     * @var string
     */
    protected string $route = 'alarm-notification.update.closed-at';

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
        $this->authUser();

        $this->get($this->routeToController())
            ->assertStatus(302)
            ->assertRedirect(route('dashboard.index'));

        $this->assertNotNull($this->rowLast()->closed_at);
    }

    /**
     * @return void
     */
    public function testPostAuthSuccess(): void
    {
        $this->authUser();

        $this->post($this->routeToController())
            ->assertStatus(302)
            ->assertRedirect(route('dashboard.index'));

        $this->assertNotNull($this->rowLast()->closed_at);
    }

    /**
     * @return string
     */
    protected function routeToController(): string
    {
        return $this->routeFactoryCreateModel();
    }
}
