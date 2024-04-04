<?php declare(strict_types=1);

namespace App\Domains\Vehicle\Test\ControllerApi;

class Create extends ControllerApiAbstract
{
    /**
     * @var string
     */
    protected string $route = 'api.vehicle.create';

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
    public function testPostGuestUnauthorizedFail(): void
    {
        $this->postGuestUnauthorizedFail();
    }

    /**
     * @return void
     */
    public function testPostAuthCreateSuccess(): void
    {
        $this->postAuthCreateSuccess();
    }

    /**
     * @return void
     */
    public function testPostAuthCreateManagerSuccess(): void
    {
        $this->postAuthCreateManagerSuccess(false, false);
    }

    /**
     * @return string
     */
    protected function routeToController(): string
    {
        return $this->route();
    }
}
