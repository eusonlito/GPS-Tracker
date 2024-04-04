<?php declare(strict_types=1);

namespace App\Domains\Trip\Test\ControllerApi;

class Update extends ControllerApiAbstract
{
    /**
     * @var string
     */
    protected string $route = 'api.trip.update';

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
        $this->patchAuthUpdateSuccess(only: ['name', 'code', 'shared', 'shared_public']);
    }

    /**
     * @return void
     */
    public function testPatchAuthUpdateManagerSuccess(): void
    {
        $this->patchAuthUpdateManagerSuccess(vehicle: false, device: false, only: ['name', 'code', 'shared', 'shared_public']);
    }

    /**
     * @return string
     */
    protected function routeToController(): string
    {
        return $this->routeFactoryCreateModel();
    }
}
