<?php declare(strict_types=1);

namespace App\Domains\User\Test\Feature;

class AuthCredentials extends FeatureAbstract
{
    /**
     * @var string
     */
    protected string $route = 'user.auth.credentials';

    /**
     * @return void
     */
    public function testGetSuccess(): void
    {
        $this->get($this->route())
            ->assertStatus(200);
    }

    /**
     * @return void
     */
    public function testPostEmptySuccess(): void
    {
        $this->post($this->route())
            ->assertStatus(200);
    }

    /**
     * @return void
     */
    public function testPostSuccess(): void
    {
        $this->factoryCreateModel();

        $this->post($this->route())
            ->assertStatus(200);
    }
}
