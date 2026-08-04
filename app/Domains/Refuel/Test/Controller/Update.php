<?php declare(strict_types=1);

namespace App\Domains\Refuel\Test\Controller;

use App\Domains\Refuel\Model\Refuel as Model;

class Update extends ControllerAbstract
{
    /**
     * @var string
     */
    protected string $route = 'refuel.update';

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
        $this->postAuthSuccess();
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
    public function testPostAuthAdminSuccess(): void
    {
        $this->postAuthAdminSuccess();
    }

    /**
     * @return void
     */
    public function testPostAuthUpdateSuccess(): void
    {
        $this->authUser();
        $this->createVehicle();

        $data = $this->factoryMake()->toArray();

        $this->post(route('refuel.create'), $data + $this->action('create'))
            ->assertStatus(302);

        $row = Model::query()->orderByDesc('id')->first();
        $expense = $this->assertExpenseSynced($row);
        $expense_id = $expense->id;

        $data = $this->factoryMake()->toArray();

        $this->post(route($this->route, $row->id), $data + $this->action())
            ->assertStatus(302)
            ->assertRedirect(route($this->route, $row->id));

        $this->dataVsRow($data, $this->rowLast());

        $row = Model::query()->byId($row->id)->first();
        $expense = $this->assertExpenseSynced($row);

        $this->assertEquals($expense_id, $expense->id);
    }

    /**
     * @return void
     */
    public function testGetAuthUpdateAdminSuccess(): void
    {
        $this->getAuthUpdateAdminSuccess();
    }

    /**
     * @return void
     */
    public function testPostAuthUpdateAdminFail(): void
    {
        $this->postAuthUpdateAdminFail(device: false);
    }

    /**
     * @return void
     */
    public function testPostAuthUpdateAdminSuccess(): void
    {
        $this->postAuthUpdateAdminSuccess();
    }

    /**
     * @return void
     */
    public function testGetAuthUpdateManagerSuccess(): void
    {
        $this->getAuthUpdateManagerSuccess(device: false);
    }

    /**
     * @return void
     */
    public function testPostAuthUpdateManagerFail(): void
    {
        $this->postAuthUpdateManagerFail(device: false);
    }

    /**
     * @return void
     */
    public function testPostAuthUpdateManagerSuccess(): void
    {
        $this->postAuthUpdateManagerSuccess(device: false);
    }

    /**
     * @return string
     */
    protected function routeToController(): string
    {
        return $this->routeFactoryCreateModel();
    }
}
