<?php declare(strict_types=1);

namespace App\Domains\User\Test\Feature;

class AuthCredentials extends FeatureAbstract
{
    /**
     * @var string
     */
    protected string $route = 'user.auth.credentials';

    /**
     * @var string
     */
    protected string $action = 'authCredentials';

    /**
     * @return void
     */
    public function testGetGuestEmptySuccess(): void
    {
        $this->get($this->routeToController())
            ->assertStatus(200);
    }

    /**
     * @return void
     */
    public function testGetGuestSuccess(): void
    {
        $this->factoryCreate();

        $this->get($this->routeToController())
            ->assertStatus(200);
    }

    /**
     * @return void
     */
    public function testPostGuestEmptySuccess(): void
    {
        $data = $this->factoryCreate()->toArray();
        $data['password'] = $data['email'];

        $this->post($this->routeToController(), $data + $this->action())
            ->assertStatus(302)
            ->assertRedirect(route('dashboard.index'));
    }

    /**
     * @return void
     */
    public function testPostGuestSuccess(): void
    {
        $this->factoryCreate();

        $data = $this->factoryCreate()->toArray();
        $data['password'] = $data['email'];

        $this->post($this->routeToController(), $data + $this->action())
            ->assertStatus(302)
            ->assertRedirect(route('dashboard.index'));
    }

    /**
     * @return string
     */
    protected function routeToController(): string
    {
        return $this->route();
    }
}
