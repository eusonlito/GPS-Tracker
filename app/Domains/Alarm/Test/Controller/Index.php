<?php declare(strict_types=1);

namespace App\Domains\Alarm\Test\Controller;

class Index extends ControllerAbstract
{
    /**
     * @var string
     */
    protected string $route = 'alarm.index';

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
    public function testGetAuthSuccess(): void
    {
        $this->getAuthSuccess();
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
    public function testGetAuthListSuccess(): void
    {
        $this->getAuthListSuccess();
    }

    /**
     * @return void
     */
    public function testGetAuthListOnlyOwnSucess(): void
    {
        $this->getAuthListOnlyOwnSucess(vehicle: false, device: false);
    }

    /**
     * @return void
     */
    public function testGetAuthListAdminSuccess(): void
    {
        $this->getAuthListAdminSuccess(vehicle: false, device: false);
    }

    /**
     * @return void
     */
    public function testGetAuthListManagerSuccess(): void
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
