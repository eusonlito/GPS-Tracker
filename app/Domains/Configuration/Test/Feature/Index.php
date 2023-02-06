<?php declare(strict_types=1);

namespace App\Domains\Configuration\Test\Feature;

class Index extends FeatureAbstract
{
    /**
     * @var string
     */
    protected string $route = 'configuration.index';

    /**
     * @return void
     */
    public function testGetUnauthorizedFail(): void
    {
        $this->get($this->route())
            ->assertStatus(302)
            ->assertRedirect(route('user.auth.credentials'));
    }

    /**
     * @return void
     */
    public function testPostUnauthorizedFail(): void
    {
        $this->post($this->route())
            ->assertStatus(405);
    }

    /**
     * @return void
     */
    public function testGetUserFail(): void
    {
        $this->authUser();

        $this->get($this->route())
            ->assertStatus(404);
    }

    /**
     * @return void
     */
    public function testGetEmptySuccess(): void
    {
        $this->authUserAdmin();

        $this->get($this->route())
            ->assertStatus(200);
    }

    /**
     * @return void
     */
    public function testGetSuccess(): void
    {
        $this->authUserAdmin();
        $this->factoryCreateModel();

        $this->get($this->route())
            ->assertStatus(200);
    }
}
