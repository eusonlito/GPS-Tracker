<?php declare(strict_types=1);

namespace App\Domains\Trip\Test\ControllerApi;

class Position extends ControllerApiAbstract
{
    /**
     * @var string
     */
    protected string $route = 'api.trip.position';

    /**
     * @return void
     */
    public function testPatchGuestNotAllowedFail(): void
    {
        $this->patchGuestNotAllowedFail();
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
    public function testGetGuestUnauthorizedFail(): void
    {
        $this->getGuestUnauthorizedFail();
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
    public function testGetAuthAdminFail(): void
    {
        $this->getAuthAdminFail();
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
    public function testGetAuthManagerSuccess(): void
    {
        $this->getAuthManagerSuccess();
    }

    /**
     * @return string
     */
    protected function routeToController(): string
    {
        return $this->routeFactoryCreateModel();
    }
}
