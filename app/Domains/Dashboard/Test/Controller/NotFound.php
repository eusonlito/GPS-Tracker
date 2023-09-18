<?php declare(strict_types=1);

namespace App\Domains\Dashboard\Test\Controller;

class NotFound extends ControllerAbstract
{
    /**
     * @return void
     */
    public function testGetGuestFail(): void
    {
        $this->get($this->routeToController())
            ->assertStatus(404);
    }

    /**
     * @return void
     */
    public function testPostGuestFail(): void
    {
        $this->post($this->routeToController())
            ->assertStatus(404);
    }

    /**
     * @return void
     */
    public function testPostAuthFail(): void
    {
        $this->authUser();

        $this->post($this->routeToController())
            ->assertStatus(404);
    }

    /**
     * @return void
     */
    public function testGetAuthFail(): void
    {
        $this->authUser();

        $this->get($this->routeToController())
            ->assertStatus(404);
    }

    /**
     * @return string
     */
    protected function routeToController(): string
    {
        return uniqid();
    }
}
