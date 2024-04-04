<?php declare(strict_types=1);

namespace App\Domains\User\Test\ControllerApi;

class Delete extends ControllerApiAbstract
{
    /**
     * @var string
     */
    protected string $route = 'api.user.delete';

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
    public function testDeleteGuestFail(): void
    {
        $this->deleteGuestFail();
    }

    /**
     * @return void
     */
    public function testDeleteAuthFail(): void
    {
        $this->deleteAuthFail();
    }

    /**
     * @return void
     */
    public function testDeleteAuthAdminSuccess(): void
    {
        $this->deleteAuthAdminSuccess();
    }

    /**
     * @return void
     */
    public function testDeleteAuthManagerFail(): void
    {
        $this->deleteAuthManagerFail();
    }

    /**
     * @return void
     */
    public function testDeleteAuthAdminManagerSuccess(): void
    {
        $this->deleteAuthAdminManagerSuccess();
    }

    /**
     * @return string
     */
    protected function routeToController(): string
    {
        return $this->routeFactoryCreateModel();
    }
}
