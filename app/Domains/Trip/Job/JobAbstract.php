<?php declare(strict_types=1);

namespace App\Domains\Trip\Job;

use App\Domains\Core\Job\JobAbstract as JobAbstractCore;
use App\Domains\Trip\Model\Trip as Model;

abstract class JobAbstract extends JobAbstractCore
{
    /**
     * @var \App\Domains\Trip\Model\Trip
     */
    protected Model $row;

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
        return [$this->middlewareWithoutOverlapping()->expireAfter(30)];
    }

    /**
     * @return \App\Domains\Trip\Model\Trip
     */
    protected function row(): Model
    {
        return $this->rowOrDeleteAndException(Model::class);
    }
}
