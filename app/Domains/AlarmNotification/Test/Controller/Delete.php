<?php declare(strict_types=1);

namespace App\Domains\AlarmNotification\Test\Controller;

class Delete extends ControllerAbstract
{
    /**
     * @var string
     */
    protected string $route = 'alarm-notification.delete';

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
    public function testGetAuthDeleteSuccess(): void
    {
        $this->getAuthDeleteSuccess('dashboard.index');
    }

    /**
     * @return void
     */
    public function testPostAuthDeleteSuccess(): void
    {
        $this->postAuthDeleteSuccess('dashboard.index');
    }

    /**
     * @return string
     */
    protected function routeToController(): string
    {
        return $this->routeFactoryCreateModel();
    }
}
