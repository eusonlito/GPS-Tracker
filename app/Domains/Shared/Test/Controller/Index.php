<?php declare(strict_types=1);

namespace App\Domains\Shared\Test\Controller;

use App\Domains\Configuration\Model\Configuration as ConfigurationModel;

class Index extends ControllerAbstract
{
    /**
     * @var string
     */
    protected string $route = 'shared.index';

    /**
     * @return void
     */
    public function testPostGuestNotAllowedFail(): void
    {
        $this->post($this->routeToController(uniqid()))
            ->assertStatus(405);
    }

    /**
     * @return void
     */
    public function testGetGuestDefaultDisabledFail(): void
    {
        $this->get($this->routeToController(uniqid()))
            ->assertStatus(404);
    }

    /**
     * @return void
     */
    public function testGetGuestDisabledSlugFail(): void
    {
        $this->setConfiguration(0, $slug = uniqid());

        $this->get($this->routeToController($slug))
            ->assertStatus(404);
    }

    /**
     * @return void
     */
    public function testGetGuestSlugInvalidFail(): void
    {
        $this->setConfiguration(1, uniqid());

        $this->get($this->routeToController(uniqid()))
            ->assertStatus(404);
    }

    /**
     * @return void
     */
    public function testGetGuestSlugEmptyFail(): void
    {
        $this->setConfiguration(1, '');

        $this->get($this->routeToController(''))
            ->assertStatus(404);
    }

    /**
     * @return void
     */
    public function testGetGuestSlugSuccess(): void
    {
        $this->setConfiguration(1, $slug = uniqid());

        $this->get($this->routeToController($slug))
            ->assertStatus(200);
    }

    /**
     * @param int $enabled
     * @param string $slug
     *
     * @return void
     */
    protected function setConfiguration(int $enabled, string $slug): void
    {
        ConfigurationModel::query()
            ->byKey('shared_enabled')
            ->update(['value' => $enabled]);

        ConfigurationModel::query()
            ->byKey('shared_slug')
            ->update(['value' => $slug]);
    }

    /**
     * @param string $slug
     *
     * @return string
     */
    protected function routeToController(string $slug): string
    {
        return $this->route(null, $slug);
    }
}
