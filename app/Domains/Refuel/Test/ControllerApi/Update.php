<?php declare(strict_types=1);

namespace App\Domains\Refuel\Test\ControllerApi;

class Update extends ControllerApiAbstract
{
    /**
     * @var string
     */
    protected string $route = 'api.refuel.update';

    /**
     * @return void
     */
    public function testGetGuestNotAllowedFail(): void
    {
        $this->getGuestNotAllowedFail();
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
    public function testPatchGuestUnauthorizedFail(): void
    {
        $this->patchGuestUnauthorizedFail();
    }

    /**
     * @return void
     */
    public function testPatchAuthUpdateSuccess(): void
    {
        $this->patchAuthUpdateSuccess();
    }

    /**
     * @return void
     */
    public function testPatchAuthUpdateManagerSuccess(): void
    {
        $this->patchAuthUpdateManagerSuccess(device: false);
    }

    /**
     * @return string
     */
    protected function routeToController(): string
    {
        return $this->routeFactoryCreateModel();
    }
}
