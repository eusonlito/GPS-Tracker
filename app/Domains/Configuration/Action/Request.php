<?php declare(strict_types=1);

namespace App\Domains\Configuration\Action;

use App\Domains\Configuration\Model\Configuration as Model;
use App\Domains\Configuration\Service\Getter\Getter as GetterService;

class Request extends ActionAbstract
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
    public function getter(): void
    {
        $this->getter = new GetterService(Model::query()->pluck('value', 'key')->all());
    }

    /**
     * @return void
     */
    protected function bind(): void
    {
        app()->bind('configuration', fn () => $this->getter);
    }
}
