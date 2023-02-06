<?php declare(strict_types=1);

namespace App\Domains\User\Test\Feature;

class Disabled extends FeatureAbstract
{
    /**
     * @var string
     */
    protected string $route = 'user.disabled';

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
            ->assertStatus(302)
            ->assertRedirect(route('user.auth.credentials'));
    }

    /**
     * @return void
     */
    public function testGetNoDisabledFail(): void
    {
        $this->authUser();

        $this->get($this->route())
            ->assertStatus(302)
            ->assertRedirect(route('dashboard.index'));
    }

    /**
     * @return void
     */
    public function testGetSuccess(): void
    {
        $row = $this->authUser();
        $row->enabled = false;
        $row->save();

        $this->get($this->route())
            ->assertStatus(200);
    }

    /**
     * @return void
     */
    public function testPostNoDisabledFail(): void
    {
        $this->authUser();

        $this->post($this->route())
            ->assertStatus(302)
            ->assertRedirect(route('dashboard.index'));
    }

    /**
     * @return void
     */
    public function testPostSuccess(): void
    {
        $row = $this->authUser();
        $row->enabled = false;
        $row->save();

        $this->post($this->route())
            ->assertStatus(200);
    }
}
