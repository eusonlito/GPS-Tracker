<?php declare(strict_types=1);

namespace App\Domains\Alarm\Test\Controller;

class Create extends ControllerAbstract
{
    /**
     * @var string
     */
    protected string $route = 'alarm.create';

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
        $this->postAuthCreateSuccess('alarm.update');
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
    public function testGetAuthCreateAdminModeSuccess(): void
    {
        $this->getAuthCreateAdminModeSuccess(false, false);
    }

    /**
     * @return void
     */
    public function testPostAuthCreateAdminModeSuccess(): void
    {
        $this->postAuthCreateAdminModeSuccess('alarm.update', false, false);
    }

    /**
     * @return string
     */
    protected function routeToController(): string
    {
        return $this->route();
    }
}
