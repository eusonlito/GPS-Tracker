<?php declare(strict_types=1);

namespace App\Domains\Country\Test\Controller;

class UpdateMerge extends ControllerAbstract
{
    /**
     * @var string
     */
    protected string $route = 'country.update.merge';

    /**
     * @var string
     */
    protected string $action = 'updateMerge';

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
    public function testPostAuthUpdateAdminSuccess(): void
    {
        $this->authUserAdmin();

        $row = $this->factoryCreate();
        $data = ['ids' => [$this->factoryCreate()->id]];

        $this->post(route($this->route, $row->id), $data + $this->action())
            ->assertStatus(302)
            ->assertRedirect(route($this->route, $row->id));

        $this->assertNull($this->getModelClass()::query()->find($data['ids'][0]));
    }

    /**
     * @return string
     */
    protected function routeToController(): string
    {
        return $this->routeFactoryCreateModel();
    }
}
