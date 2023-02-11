<?php declare(strict_types=1);

namespace App\Domains\Trip\Test\Controller;

class Shared extends ControllerAbstract
{
    /**
     * @var string
     */
    protected string $route = 'trip.shared';

    /**
     * @return void
     */
    public function testPostGuestNotAllowedFail(): void
    {
        $this->post($this->routeToController())
            ->assertStatus(405);
    }

    /**
     * @return void
     */
    public function testGetGuestSuccess(): void
    {
        $this->get($this->routeToController())
            ->assertStatus(200);
    }

    /**
     * @return string
     */
    protected function routeToController(): string
    {
        return $this->route(null, $this->factoryCreate()->code);
    }
}
