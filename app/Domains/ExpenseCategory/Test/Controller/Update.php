<?php declare(strict_types=1);

namespace App\Domains\ExpenseCategory\Test\Controller;

class Update extends ControllerAbstract
{
    /**
     * @var string
     */
    protected string $route = 'expense-category.update';

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
    public function testPostAuthUpdateSuccess(): void
    {
        $this->postAuthUpdateSuccess();
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
    public function testPostAuthUpdateManagerSuccess(): void
    {
        $this->postAuthUpdateManagerSuccess(vehicle: false, device: false);
    }

    /**
     * @return string
     */
    protected function routeToController(): string
    {
        return $this->routeFactoryCreateModel();
    }
}
