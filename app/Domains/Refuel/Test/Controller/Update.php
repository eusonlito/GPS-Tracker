<?php declare(strict_types=1);

namespace App\Domains\Refuel\Test\Controller;

class Update extends ControllerAbstract
{
    /**
     * @var string
     */
    protected string $route = 'refuel.update';

    /**
     * @var string
     */
    protected string $action = 'update';

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
    public function testpostAuthUpdateSuccess(): void
    {
        $this->postAuthUpdateSuccess();
    }

    /**
     * @return void
     */
    public function testgetAuthUpdateAdminSuccess(): void
    {
        $this->getAuthUpdateAdminSuccess();
    }

    /**
     * @return void
     */
    public function testpostAuthUpdateAdminFail(): void
    {
        $this->postAuthUpdateAdminFail(device: false);
    }

    /**
     * @return void
     */
    public function testpostAuthUpdateAdminSuccess(): void
    {
        $this->postAuthUpdateAdminSuccess();
    }

    /**
     * @return void
     */
    public function testgetAuthUpdateAdminModeSuccess(): void
    {
        $this->getAuthUpdateAdminModeSuccess(device: false);
    }

    /**
     * @return void
     */
    public function testpostAuthUpdateAdminModeFail(): void
    {
        $this->postAuthUpdateAdminModeFail(device: false);
    }

    /**
     * @return void
     */
    public function testpostAuthUpdateAdminModeSuccess(): void
    {
        $this->postAuthUpdateAdminModeSuccess(device: false);
    }

    /**
     * @return string
     */
    protected function routeToController(): string
    {
        return $this->routeFactoryCreateModel();
    }
}
