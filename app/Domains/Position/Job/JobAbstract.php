<?php declare(strict_types=1);

namespace App\Domains\Position\Job;

use Illuminate\Queue\Middleware\WithoutOverlapping;
use App\Domains\Position\Model\Position as Model;
use App\Domains\Shared\Job\JobAbstract as JobAbstractShared;

abstract class JobAbstract extends JobAbstractShared
{
    /**
     * @var int
     */
    protected int $id;

    /**
     * @param int $id
     *
     * @return void
     */
    public function __construct(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return array
     */
    public function middleware()
    {
        return [(new WithoutOverlapping((string)$this->id))->expireAfter(30)];
    }

    /**
     * @return \App\Domains\Position\Model\Position
     */
    protected function row(): Model
    {
        return Model::selectPointAsLatitudeLongitude()->findOrFail($this->id);
    }
}
