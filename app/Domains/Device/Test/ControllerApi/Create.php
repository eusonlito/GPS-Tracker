<?php declare(strict_types=1);

namespace App\Domains\Device\Test\ControllerApi;

class Create extends ControllerApiAbstract
{
    /**
     * @var string
     */
    protected string $route = 'api.device.create';

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
        $this->postAuthCreateSuccess(['code', 'connected_at']);
    }

    /**
     * @return void
     */
    public function testPostAuthCreateManagerSuccess(): void
    {
        $this->postAuthCreateManagerSuccess(true, false, ['code', 'connected_at']);
    }

    /**
     * @return string
     */
    protected function routeToController(): string
    {
        return $this->route();
    }
}
