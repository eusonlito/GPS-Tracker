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
    public function testpostAuthCreateSuccess(): void
    {
        $this->postAuthCreateSuccess();
    }

    /**
     * @return void
     */
    public function testgetAuthCreateAdminSuccess(): void
    {
        $this->getAuthCreateAdminSuccess();
    }

    /**
     * @return void
     */
    public function testpostAuthCreateAdminFail(): void
    {
        $this->postAuthCreateAdminFail();
    }

    /**
     * @return void
     */
    public function testpostAuthCreateAdminSuccess(): void
    {
        $this->postAuthCreateAdminSuccess();
    }

    /**
     * @return void
     */
    public function testgetAuthCreateAdminModeSuccess(): void
    {
        $this->getAuthCreateAdminModeSuccess(vehicle: false, device: false);
    }

    /**
     * @return string
     */
    protected function routeToController(): string
    {
        return $this->route();
    }
}
