<?php declare(strict_types=1);

namespace App\Domains\Trip\Test\Controller;

class UpdateMerge extends ControllerAbstract
{
    /**
     * @var string
     */
    protected string $route = 'trip.update.merge';

    /**
     * @var string
     */
    protected string $action = 'updateMerge';

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
    public function testPostGuestUnauthorizedFail(): void
    {
        $this->postGuestUnauthorizedFail();
    }

    /**
     * @return void
     */
    public function testGetAuthSuccess(): void
    {
        $this->getAuthSuccess();
    }

    /**
     * @return void
     */
    public function testPostAuthSuccess(): void
    {
        $this->postAuthSuccess();
    }

    /**
     * @return string
     */
    protected function routeToController(): string
    {
        return $this->routeFactoryCreateModel();
    }
}
