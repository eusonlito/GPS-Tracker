<?php declare(strict_types=1);

namespace App\Domains\Trip\Test\Controller;

class Update extends ControllerAbstract
{
    /**
     * @var string
     */
    protected string $route = 'trip.update';

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
    public function testGetAuthSharedSuccess(): void
    {
        $this->authUser();
        $this->factoryCreate(data: [
            'shared' => true,
            'shared_public' => true,
        ]);

        $this->get($this->routeFactoryLastModel())
            ->assertStatus(200);
    }

    /**
     * @return void
     */
    public function testPostAuthSuccess(): void
    {
        $this->authUser();

        $data = $this->factoryMake()->toArray();

        $this->post($this->routeToController(), $data + $this->action())
            ->assertStatus(302)
            ->assertRedirect(route($this->route, $this->rowLast()->id));

        $this->factoryCreate();

        $data = $this->factoryMake()->toArray();

        $this->post($this->routeToController(), $data + $this->action())
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
