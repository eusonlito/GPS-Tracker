<?php declare(strict_types=1);

namespace App\Domains\Refuel\Job;

use App\Domains\Core\Job\JobAbstract as JobAbstractCore;
use App\Domains\Refuel\Model\Refuel as Model;

abstract class JobAbstract extends JobAbstractCore
{
    /**
     * @var \App\Domains\Refuel\Model\Refuel
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
        return [$this->middlewareWithoutOverlapping()];
    }

    /**
     * @return \App\Domains\Refuel\Model\Refuel
     */
    protected function row(): Model
    {
        return $this->rowOrDeleteAndException(Model::class);
    }
}
