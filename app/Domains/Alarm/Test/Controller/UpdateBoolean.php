<?php declare(strict_types=1);

namespace App\Domains\Alarm\Test\Controller;

class UpdateBoolean extends ControllerAbstract
{
    /**
     * @var string
     */
    protected string $route = 'alarm.update.boolean';

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
    public function testGetAuthInvalidFail(): void
    {
        $this->getAuthInvalidFail();
    }

    /**
     * @return void
     */
    public function testPostAuthInvalidFail(): void
    {
        $this->postAuthInvalidFail();
    }

    /**
     * @return void
     */
    public function testPostAuthSuccess(): void
    {
        $this->postAuthSuccess();
    }

    /**
     * @return string
     */
    protected function routeToController(): string
    {
        return $this->routeFactoryCreateModel(null, 'enabled');
    }
}
