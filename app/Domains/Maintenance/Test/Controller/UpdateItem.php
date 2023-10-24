<?php declare(strict_types=1);

namespace App\Domains\Maintenance\Test\Controller;

class UpdateItem extends ControllerAbstract
{
    /**
     * @var string
     */
    protected string $route = 'maintenance.update.item';

    /**
     * @var string
     */
    protected string $action = 'updateItem';

    /**
     * @return void
     */
    public function testGetGuestUnauthorizedFail(): void
    {
        $this->get($this->routeToController())
            ->assertStatus(302)
            ->assertRedirect(route('user.auth.credentials'));
    }

    /**
     * @return void
     */
    public function testGetGuestFail(): void
    {
        $this->post($this->routeToController())
            ->assertStatus(302)
            ->assertRedirect(route('user.auth.credentials'));
    }

    /**
     * @return void
     */
    public function testGetAuthEmptySuccess(): void
    {
        $this->authUser();

        $this->get($this->routeToController())
            ->assertStatus(200);
    }

    /**
     * @return void
     */
    public function testGetAuthSuccess(): void
    {
        $this->authUser();
        $this->factoryCreate();

        $this->get($this->routeToController())
            ->assertStatus(200);
    }

    /**
     * @return void
     */
    public function testPostAuthEmptySuccess(): void
    {
        $this->authUser();

        $this->post($this->routeToController(), $this->action())
            ->assertStatus(302)
            ->assertRedirect(route($this->route, $this->rowLast()->id));
    }

    /**
     * @return void
     */
    public function testPostAuthSuccess(): void
    {
        $this->authUser();
        $this->factoryCreate();

        $this->post($this->routeToController(), $this->action())
            ->assertStatus(302)
            ->assertRedirect(route($this->route, $this->rowLast()->id));
    }

    /**
     * @return string
     */
    protected function routeToController(): string
    {
        return $this->routeFactoryCreateModel();
    }
}
