<?php declare(strict_types=1);

namespace App\Domains\Timezone\Test\Controller;

class UpdateDefault extends ControllerAbstract
{
    /**
     * @var string
     */
    protected string $route = 'timezone.update.default';

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
        $this->authUserAdmin();

        $row = $this->factoryCreate(data: ['default' => false]);

        $this->assertFalse($row->default);

        $this->get($this->route(null, $row->id))
            ->assertStatus(302);

        $row = $row->fresh();

        $this->assertTrue($row->default);
    }

    /**
     * @return void
     */
    public function testPostAuthAdminSuccess(): void
    {
        $this->authUserAdmin();

        $row = $this->factoryCreate(data: ['default' => false]);

        $this->assertFalse($row->default);

        $this->post($this->route(null, $row->id))
            ->assertStatus(302);

        $row = $row->fresh();

        $this->assertTrue($row->default);
    }

    /**
     * @return string
     */
    protected function routeToController(): string
    {
        return $this->routeFactoryCreateModel();
    }
}
