<?php declare(strict_types=1);

namespace App\Domains\Alarm\Job;

class CheckPosition extends JobAbstract
{
    /**
     * @param int $position_id
     *
     * @return void
     */
    public function __construct(protected int $position_id)
    {
    }

    /**
     * @return array
     */
    public function middleware(): array
    {
        return [$this->middlewareWithoutOverlapping($this->position_id)->expireAfter(30)];
    }

    /**
     * @return void
     */
    public function handle(): void
    {
        $this->factory()->action(['position_id' => $this->position_id])->checkPosition();
    }
}
