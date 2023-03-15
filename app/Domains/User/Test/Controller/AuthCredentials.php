<?php declare(strict_types=1);

namespace App\Domains\User\Test\Controller;

use App\Domains\IpLock\Model\IpLock as IpLockModel;

class AuthCredentials extends ControllerAbstract
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
    public function testPostFail(): void
    {
        $data = [$this->factoryCreate()->email];

        $this->post($this->routeToController(), $data + $this->action())
            ->assertStatus(422)
            ->assertViewIs('domains.user.auth-credentials');

        $data = ['password' => uniqid()];

        $this->post($this->routeToController(), $data + $this->action())
            ->assertStatus(422)
            ->assertViewIs('domains.user.auth-credentials');
    }

    /**
     * @return void
     */
    public function testPostIpLockFail(): void
    {
        $route = $this->routeToController();
        $limit = (int)config('auth.lock.allowed');

        $data = $this->factoryCreate()->only('email')
            + ['password' => uniqid()]
            + $this->action();

        for ($i = 0; $i < $limit; $i++) {
            $this->post($route, $data)
                ->assertStatus(401)
                ->assertViewIs('domains.user.auth-credentials');
        }

        $this->assertEquals(IpLockModel::query()->count(), 0);

        $this->post($route, $data)
            ->assertStatus(422)
            ->assertViewIs('domains.user.auth-credentials');

        $this->assertEquals(IpLockModel::query()->count(), 1);
    }

    /**
     * @return void
     */
    public function testPostSuccess(): void
    {
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
