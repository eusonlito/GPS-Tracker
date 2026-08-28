<?php declare(strict_types=1);

namespace App\Domains\Expense\Test\Controller;

class Delete extends ControllerAbstract
{
    /**
     * @var string
     */
    protected string $route = 'expense.update';

    /**
     * @var string
     */
    protected string $action = 'delete';

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
    public function testPostAuthAdminSuccess(): void
    {
        $this->createVehicle();
        $this->postAuthAdminSuccess();
    }

    /**
     * @return void
     */
    public function testGetAuthDeleteFail(): void
    {
        $this->createVehicle();
        $this->getAuthDeleteFail();
    }

    /**
     * @return void
     */
    public function testPostAuthDeleteSuccess(): void
    {
        $this->createVehicle();
        $this->postAuthDeleteSuccess();
    }

    /**
     * @return void
     */
    public function testGetAuthAdminDeleteFail(): void
    {
        $this->createVehicle();
        $this->getAuthAdminDeleteFail();
    }

    /**
     * @return void
     */
    public function testPostAuthAdminDeleteFail(): void
    {
        $this->createVehicle();
        $this->postAuthAdminDeleteFail();
    }

    /**
     * @return void
     */
    public function testPostAuthManagerDeleteSuccess(): void
    {
        $this->createVehicle();
        $this->postAuthManagerDeleteSuccess();
    }

    /**
     * @return string
     */
    protected function routeToController(): string
    {
        return $this->routeFactoryCreateModel();
    }
}
