<?php declare(strict_types=1);

namespace App\Domains\Core\Job;

use Throwable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\Middleware\WithoutOverlapping;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Domains\Core\Model\ModelAbstract;
use App\Domains\Core\Traits\Factory;

abstract class JobAbstract implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    use Factory;

    /**
     * @param \Throwable $e
     *
     * @return void
     */
    public function failed(Throwable $e): void
    {
        logger()->error($e);

        if (app()->bound('sentry')) {
            app('sentry')->captureException($e);
        }
    }

    /**
     * @param int|string|null $id = null
     *
     * @return \Illuminate\Queue\Middleware\WithoutOverlapping
     */
    protected function middlewareWithoutOverlapping(int|string|null $id = null): WithoutOverlapping
    {
        return new WithoutOverlapping(strval($id ?: $this->id));
    }

    /**
     * @return void
     */
    protected function deleteAndException(): void
    {
        $this->delete();

        throw new ModelNotFoundException();
    }

    /**
     * @param string $class
     *
     * @return \App\Domains\Core\Model\ModelAbstract
     */
    protected function rowOrDeleteAndException(string $class): ModelAbstract
    {
        return $this->row = $class::query()->byId($this->id)->firstOr(fn () => $this->deleteAndException());
    }
}
