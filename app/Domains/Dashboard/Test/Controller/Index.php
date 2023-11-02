<?php declare(strict_types=1);

namespace App\Domains\Dashboard\Test\Controller;

class Index extends ControllerAbstract
{
    /**
     * @var string
     */
    protected string $route = 'dashboard.index';

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
     * @return string
     */
    protected function routeToController(): string
    {
        return $this->route();
    }
}
