<?php declare(strict_types=1);

namespace App\Domains\Configuration\Action;

use App\Domains\Configuration\Model\Configuration as Model;
use App\Domains\Configuration\Service\Getter\Getter as GetterService;

class AppBind extends ActionAbstract
{
    /**
     * @var \App\Domains\Configuration\Service\Getter\Getter
     */
    protected GetterService $getter;

    /**
     * @return void
     */
    public function handle(): void
    {
        $this->getter();
        $this->bind();
    }

    /**
     * @return void
     */
    protected function getter(): void
    {
        $this->getter = new GetterService($this->list());
    }

    /**
     * @return array
     */
    protected function list(): array
    {
        if ($this->listAvailable()) {
            return Model::query()->pluck('value', 'key')->all();
        }

        return [];
    }

    /**
     * @return bool
     */
    protected function listAvailable(): bool
    {
        return Model::schema()->hasTable(Model::TABLE);
    }

    /**
     * @return void
     */
    protected function bind(): void
    {
        app()->bind('configuration', fn () => $this->getter);
    }
}
