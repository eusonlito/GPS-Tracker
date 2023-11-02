<?php declare(strict_types=1);

namespace App\Domains\Profile\Test\Controller;

class UpdateUserSession extends ControllerAbstract
{
    /**
     * @var string
     */
    protected string $route = 'profile.update.user-session';

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
    public function testPostGuestNotAllowedFail(): void
    {
        $this->postGuestNotAllowedFail();
    }

    /**
     * @return void
     */
    public function testPostAuthNotAllowedFail(): void
    {
        $this->postAuthNotAllowedFail();
    }

    /**
     * @return void
     */
    public function testGetAuthSuccess(): void
    {
        $this->getAuthSuccess();
    }

    /**
     * @return string
     */
    protected function routeToController(): string
    {
        return $this->route();
    }
}
