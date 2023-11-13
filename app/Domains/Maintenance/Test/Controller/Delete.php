<?php declare(strict_types=1);

namespace App\Domains\Maintenance\Test\Controller;

class Delete extends ControllerAbstract
{
    /**
     * @var string
     */
    protected string $route = 'maintenance.update';

    /**
     * @var string
     */
    protected string $action = 'delete';

    /**
     * @return void
     */
    public function testgetGuestUnauthorizedFail(): void
    {
        $this->getGuestUnauthorizedFail();
    }

    /**
     * @return void
     */
    public function testpostGuestUnauthorizedFail(): void
    {
        $this->postGuestUnauthorizedFail();
    }

    /**
     * @return void
     */
    public function testgetAuthSuccess(): void
    {
        $this->getAuthSuccess();
    }

    /**
     * @return void
     */
    public function testpostAuthSuccess(): void
    {
        $this->postAuthSuccess();
    }

    /**
     * @return void
     */
    public function testgetAuthAdminSuccess(): void
    {
        $this->getAuthAdminSuccess();
    }

    /**
     * @return void
     */
    public function testpostAuthAdminSuccess(): void
    {
        $this->postAuthAdminSuccess();
    }

    /**
     * @return void
     */
    public function testgetAuthDeleteFail(): void
    {
        $this->getAuthDeleteFail();
    }

    /**
     * @return void
     */
    public function testpostAuthDeleteSuccess(): void
    {
        $this->postAuthDeleteSuccess();
    }

    /**
     * @return void
     */
    public function testgetAuthAdminDeleteFail(): void
    {
        $this->getAuthAdminDeleteFail();
    }

    /**
     * @return void
     */
    public function testpostAuthAdminDeleteFail(): void
    {
        $this->postAuthAdminDeleteFail();
    }

    /**
     * @return void
     */
    public function testpostAuthManagerDeleteSuccess(): void
    {
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
