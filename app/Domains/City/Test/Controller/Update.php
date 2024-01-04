<?php declare(strict_types=1);

namespace App\Domains\City\Test\Controller;

class Update extends ControllerAbstract
{
    /**
     * @var string
     */
    protected string $route = 'city.update';

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
        $data = $this->factoryMake(data: [
            'point' => null,
            'alias' => 'Name,Name2',
            'latitude' => 42.34818,
            'longitude' => -7.9126,
        ])->toArray();

        $this->post(route($this->route, $row->id), $data + $this->action())
            ->assertStatus(302)
            ->assertRedirect(route($this->route, $row->id));

        $data['alias'] = explode(',', $data['alias']);

        $this->dataVsRow($data, $this->rowLast());
    }

    /**
     * @return string
     */
    protected function routeToController(): string
    {
        return $this->routeFactoryCreateModel();
    }
}
