<?php declare(strict_types=1);

namespace App\Domains\MaintenanceItem\Test\Controller;

class Index extends ControllerAbstract
{
    /**
     * @var string
     */
    protected string $route = 'maintenance-item.index';

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
    public function testpostGuestNotAllowedFail(): void
    {
        $this->postGuestNotAllowedFail();
    }

    /**
     * @return void
     */
    public function testpostAuthNotAllowedFail(): void
    {
        $this->postAuthNotAllowedFail();
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
    public function testgetAuthAdminSuccess(): void
    {
        $this->getAuthAdminSuccess();
    }

    /**
     * @return void
     */
    public function testgetAuthListSuccess(): void
    {
        $this->getAuthListSuccess();
    }

    /**
     * @return void
     */
    public function testgetAuthListOnlyOwnSucess(): void
    {
        $this->getAuthListOnlyOwnSucess(vehicle: false, device: false);
    }

    /**
     * @return void
     */
    public function testgetAuthListAdminSuccess(): void
    {
        $this->getAuthListAdminSuccess(vehicle: false, device: false);
    }

    /**
     * @return void
     */
    public function testgetAuthListManagerSuccess(): void
    {
        $this->getAuthListManagerSuccess(vehicle: false, device: false);
    }

    /**
     * @return string
     */
    protected function routeToController(): string
    {
        return $this->route();
    }
}
