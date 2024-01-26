<?php declare(strict_types=1);

namespace App\Domains\Position\Job;

use App\Domains\Position\Model\Position as Model;
use App\Domains\Core\Job\JobAbstract as JobAbstractCore;

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
        return [$this->middlewareWithoutOverlapping()];
    }

    /**
     * @return \App\Domains\Position\Model\Position
     */
    protected function row(): Model
    {
        return $this->rowOrDeleteAndException(Model::class);
    }
}
