<?php declare(strict_types=1);

namespace App\Domains\Trip\Test\Feature;

class Shared extends FeatureAbstract
{
    /**
     * @var string
     */
    protected string $route = 'trip.shared';

    /**
     * @return void
     */
    public function testPostFail(): void
    {
        $this->post($this->route(null, $this->factoryCreateModel()->code))
            ->assertStatus(405);
    }

    /**
     * @return void
     */
    public function testGetSuccess(): void
    {
        $this->get($this->route(null, $this->factoryCreateModel()->code))
            ->assertStatus(200);
    }
}
