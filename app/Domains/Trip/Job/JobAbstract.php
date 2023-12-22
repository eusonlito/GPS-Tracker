<?php declare(strict_types=1);

namespace App\Domains\Trip\Job;

use Illuminate\Queue\Middleware\WithoutOverlapping;
use App\Domains\Core\Job\JobAbstract as JobAbstractCore;
use App\Domains\Trip\Model\Trip as Model;

abstract class JobAbstract extends JobAbstractCore
{
    /**
     * @param int $id
     *
     * @return void
     */
    public function __construct(protected int $id)
    {
    }

    /**
     * @return array
     */
    public function middleware(): array
    {
        return [(new WithoutOverlapping((string)$this->id))->expireAfter(30)];
    }

    /**
     * @return \App\Domains\Trip\Model\Trip
     */
    protected function row(): Model
    {
        return Model::query()->byId($this->id)->firstOr(fn () => $this->findOrDeleteJob());
    }
}
