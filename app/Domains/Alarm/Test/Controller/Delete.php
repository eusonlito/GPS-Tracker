<?php declare(strict_types=1);

namespace App\Domains\Alarm\Test\Controller;

class Delete extends ControllerAbstract
{
    /**
     * @var string
     */
    protected string $route = 'alarm.update';

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
    public function testGetAuthDeleteFail(): void
    {
        $this->getAuthDeleteFail();
    }

    /**
     * @return void
     */
    public function testPostAuthDeleteSuccess(): void
    {
        $this->postAuthDeleteSuccess('alarm.index');
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
    public function testPostAuthAdminModeDeleteSuccess(): void
    {
        $this->postAuthAdminModeDeleteSuccess('alarm.index');
    }

    /**
     * @return string
     */
    protected function routeToController(): string
    {
        return $this->routeFactoryCreateModel();
    }
}
