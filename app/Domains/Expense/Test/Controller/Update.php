<?php declare(strict_types=1);

namespace App\Domains\Expense\Test\Controller;

use App\Domains\ExpenseCategory\Model\ExpenseCategory as ExpenseCategoryModel;

class Update extends ControllerAbstract
{
    /**
     * @var string
     */
    protected string $route = 'expense.update';

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
        $this->createVehicle();
        $this->getAuthSuccess();
    }

    /**
     * @return void
     */
    public function testPostAuthSuccess(): void
    {
        $this->createVehicle();
        $this->postAuthSuccess();
    }

    /**
     * @return void
     */
    public function testGetAuthAdminSuccess(): void
    {
        $this->createVehicle();
        $this->getAuthAdminSuccess();
    }

    /**
     * @return void
     */
    public function testPostAuthUpdateSuccess(): void
    {
        $this->createVehicle();
        $this->postAuthUpdateSuccess();
    }

    /**
     * @return void
     */
    public function testPostAuthUpdateAdminSuccess(): void
    {
        $this->createVehicle();
        $this->postAuthUpdateAdminSuccess();
    }

    /**
     * @return void
     */
    public function testPostAuthUpdateManagerSuccess(): void
    {
        $this->createVehicle();

        $user1 = $this->authUserManager();
        $this->createVehicle($user1);

        [$user2, $vehicle2, $device2, $row2] = $this->createUserVehicleDeviceRow(true, false);
        $vehicle2 = $this->createVehicle($user2);

        $category = ExpenseCategoryModel::factory()->create(['user_id' => $user2->id]);

        $data = $this->dataWithUserVehicleDeviceMake($user2, $vehicle2, null);
        $data['expense_category_id'] = $category->id;

        $this->post(route($this->route, $row2->id), $data + $this->action())
            ->assertStatus(302)
            ->assertRedirect(route($this->route, $row2->id));

        $row2 = $this->rowFresh($row2);

        $this->assertEquals($user2->id, $row2->user_id);
        $this->assertEquals($vehicle2->id, $row2->vehicle_id);
        $this->assertEquals($category->id, $row2->expense_category_id);
    }

    /**
     * @return string
     */
    protected function routeToController(): string
    {
        return $this->routeFactoryCreateModel();
    }
}
