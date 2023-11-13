<?php declare(strict_types=1);

namespace App\Domains\Device\Test\Controller;

class Create extends ControllerAbstract
{
    /**
     * @var string
     */
    protected string $route = 'device.create';

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
    public function testPostAuthSuccess(): void
    {
        $this->postAuthSuccess();
    }

    /**
     * @return void
     */
    public function testPostAuthCreateSuccess(): void
    {
        $this->postAuthCreateSuccess('device.update', ['code', 'connected_at']);
    }

    /**
     * @return void
     */
    public function testGetAuthCreateAdminSuccess(): void
    {
        $this->getAuthCreateAdminSuccess();
    }

    /**
     * @return void
     */
    public function testGetAuthCreateManagerSuccess(): void
    {
        $this->getAuthCreateManagerSuccess(true, false);
    }

    /**
     * @return void
     */
    public function testPostAuthCreateManagerSuccess(): void
    {
        $this->postAuthCreateManagerSuccess('device.update', true, false, ['code', 'connected_at']);
    }

    /**
     * @return string
     */
    protected function routeToController(): string
    {
        return $this->route();
    }
}
