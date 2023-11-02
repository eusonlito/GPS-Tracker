<?php declare(strict_types=1);

namespace App\Domains\MaintenanceItem\Test\Controller;

class Create extends ControllerAbstract
{
    /**
     * @var string
     */
    protected string $route = 'maintenance-item.create';

    /**
     * @var string
     */
    protected string $action = 'create';

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
    public function testPostAuthCreateSuccess(): void
    {
        $this->postAuthCreateSuccess('maintenance-item.update');
    }

    /**
     * @return string
     */
    protected function routeToController(): string
    {
        return $this->route();
    }
}
