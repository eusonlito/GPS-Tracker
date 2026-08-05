<?php declare(strict_types=1);

namespace App\Domains\Expense\Test\Controller;

use App\Domains\ExpenseCategory\Model\ExpenseCategory as ExpenseCategoryModel;

class Stat extends ControllerAbstract
{
    /**
     * @var string
     */
    protected string $route = 'expense.stat';

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
    public function testPostGuestNotAllowedFail(): void
    {
        $this->postGuestNotAllowedFail();
    }

    /**
     * @return void
     */
    public function testPostAuthNotAllowedFail(): void
    {
        $this->postAuthNotAllowedFail();
    }

    /**
     * @return void
     */
    public function testGetAuthNoVehicleFail(): void
    {
        $this->authUser();

        $this->get($this->routeToController())
            ->assertStatus(302)
            ->assertRedirect(route('vehicle.create'));
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
    public function testGetAuthListSuccess(): void
    {
        $this->createVehicle();
        $this->authUser();

        $row = $this->factoryCreate();

        $this->get($this->routeToController())
            ->assertStatus(200)
            ->assertSeeText($row->category->name)
            ->assertSeeText(__('expense-stat.stats.total'))
            ->assertSeeText(__('expense-stat.section.categories'));
    }

    /**
     * @return void
     */
    public function testGetAuthListOnlyOwnSucess(): void
    {
        $this->createVehicle();

        $user1 = $this->authUser();
        $user2 = $this->createUser();

        $category1 = ExpenseCategoryModel::factory()->create(['user_id' => $user1->id, 'name' => 'Category Own A']);
        $category2 = ExpenseCategoryModel::factory()->create(['user_id' => $user2->id, 'name' => 'Category Own B']);

        $vehicle1 = $this->createVehicle($user1);
        $vehicle2 = $this->createVehicle($user2);

        $this->factoryCreate(data: [
            'user_id' => $user1->id,
            'vehicle_id' => $vehicle1->id,
            'expense_category_id' => $category1->id,
        ]);

        $this->factoryCreate(data: [
            'user_id' => $user2->id,
            'vehicle_id' => $vehicle2->id,
            'expense_category_id' => $category2->id,
        ]);

        $this->get($this->routeToController().'?vehicle_id=')
            ->assertStatus(200)
            ->assertSeeText($category1->name)
            ->assertDontSeeText($category2->name)
            ->assertDontSeeText($user2->name)
            ->assertSeeText($vehicle1->name)
            ->assertDontSeeText($vehicle2->name);

        $this->auth($user2);

        $this->get($this->routeToController().'?vehicle_id=')
            ->assertStatus(200)
            ->assertSeeText($category2->name)
            ->assertDontSeeText($category1->name)
            ->assertSeeText($vehicle2->name)
            ->assertDontSeeText($vehicle1->name);
    }

    /**
     * @return void
     */
    public function testGetAuthListAdminSuccess(): void
    {
        $this->createVehicle();

        $user1 = $this->authUserAdmin();
        $user2 = $this->createUser();

        $category1 = ExpenseCategoryModel::factory()->create(['user_id' => $user1->id, 'name' => 'Category Admin A']);
        $category2 = ExpenseCategoryModel::factory()->create(['user_id' => $user2->id, 'name' => 'Category Admin B']);

        $vehicle1 = $this->createVehicle($user1);
        $vehicle2 = $this->createVehicle($user2);

        $this->factoryCreate(data: [
            'user_id' => $user1->id,
            'vehicle_id' => $vehicle1->id,
            'expense_category_id' => $category1->id,
        ]);

        $this->factoryCreate(data: [
            'user_id' => $user2->id,
            'vehicle_id' => $vehicle2->id,
            'expense_category_id' => $category2->id,
        ]);

        $this->get($this->routeToController().'?vehicle_id=')
            ->assertStatus(200)
            ->assertSeeText($category1->name)
            ->assertDontSeeText($category2->name)
            ->assertDontSeeText($user2->name)
            ->assertSeeText($vehicle1->name)
            ->assertDontSeeText($vehicle2->name);
    }

    /**
     * @return void
     */
    public function testGetAuthListManagerSuccess(): void
    {
        $this->createVehicle();

        $user1 = $this->authUserManager();
        $user2 = $this->createUser();

        $category1 = ExpenseCategoryModel::factory()->create(['user_id' => $user1->id, 'name' => 'Category Manager A']);
        $category2 = ExpenseCategoryModel::factory()->create(['user_id' => $user2->id, 'name' => 'Category Manager B']);

        $vehicle1 = $this->createVehicle($user1);
        $vehicle2 = $this->createVehicle($user2);

        $this->factoryCreate(data: [
            'user_id' => $user1->id,
            'vehicle_id' => $vehicle1->id,
            'expense_category_id' => $category1->id,
        ]);

        $this->factoryCreate(data: [
            'user_id' => $user2->id,
            'vehicle_id' => $vehicle2->id,
            'expense_category_id' => $category2->id,
        ]);

        $this->get($this->routeToController().'?user_id=&vehicle_id=')
            ->assertStatus(200)
            ->assertSeeText($category1->name)
            ->assertSeeText($category2->name)
            ->assertSeeText($user1->name)
            ->assertSeeText($user2->name)
            ->assertSeeText($vehicle1->name)
            ->assertSeeText($vehicle2->name);

        $this->get($this->routeToController().'?user_id='.$user2->id.'&vehicle_id=')
            ->assertStatus(200)
            ->assertDontSeeText($category1->name)
            ->assertSeeText($category2->name)
            ->assertSeeText($user1->name)
            ->assertSeeText($user2->name)
            ->assertDontSeeText($vehicle1->name)
            ->assertSeeText($vehicle2->name);
    }

    /**
     * @return string
     */
    protected function routeToController(): string
    {
        return $this->route();
    }
}
