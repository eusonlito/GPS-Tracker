<?php declare(strict_types=1);

namespace App\Domains\Server\Test\Controller;

class UpdateBoolean extends ControllerAbstract
{
    /**
     * @var string
     */
    protected string $route = 'server.update.boolean';

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
    public function testGetAuthUnauthorizedFail(): void
    {
        $this->getAuthUnauthorizedFail();
    }

    /**
     * @return void
     */
    public function testPostAuthUnauthorizedFail(): void
    {
        $this->postAuthUnauthorizedFail();
    }

    /**
     * @return void
     */
    public function testGetAuthAdminInvalidFail(): void
    {
        $this->getAuthAdminInvalidFail();
    }

    /**
     * @return void
     */
    public function testPostAuthAdminInvalidFail(): void
    {
        $this->postAuthAdminInvalidFail();
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
    public function testPostAuthAdminSuccess(): void
    {
        $this->postAuthAdminSuccess();
    }

    /**
     * @return string
     */
    protected function routeToController(): string
    {
        return $this->routeFactoryCreateModel(null, 'enabled');
    }
}
