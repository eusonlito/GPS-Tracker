<?php declare(strict_types=1);

namespace App\Domains\Vehicle\Test\Controller;

class Delete extends ControllerAbstract
{
    /**
     * @var string
     */
    protected string $route = 'vehicle.update';

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
    public function testGetAuthDeleteFail(): void
    {
        $this->getAuthDeleteFail();
    }

    /**
     * @return void
     */
    public function testPostAuthDeleteSuccess(): void
    {
        $this->postAuthDeleteSuccess();
    }

    /**
     * @return void
     */
    public function testGetAuthAdminDeleteFail(): void
    {
        $this->getAuthAdminDeleteFail();
    }

    /**
     * @return void
     */
    public function testPostAuthAdminDeleteFail(): void
    {
        $this->postAuthAdminDeleteFail();
    }

    /**
     * @return void
     */
    public function testPostAuthManagerDeleteSuccess(): void
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
