<?php declare(strict_types=1);

namespace App\Domains\QueueFail\Model;

use App\Domains\CoreApp\Model\ModelAbstract;
use App\Domains\QueueFail\Model\Builder\QueueFail as Builder;
use App\Domains\QueueFail\Model\Collection\QueueFail as Collection;

class QueueFail extends ModelAbstract
{
    /**
     * @var string
     */
    protected $table = 'queue_fail';

    /**
     * @const string
     */
    public const TABLE = 'queue_fail';

    /**
     * @const string
     */
    public const FOREIGN = 'queue_fail_id';

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'payload' => 'array',
    ];

    /**
     * @param array $models
     *
     * @return \App\Domains\QueueFail\Model\Collection\QueueFail
     */
    public function newCollection(array $models = []): Collection
    {
        return new Collection($models);
    }

    /**
     * @param \Illuminate\Database\Query\Builder $query
     *
     * @return \App\Domains\QueueFail\Model\Builder\QueueFail
     */
    public function newEloquentBuilder($query): Builder
    {
        return new Builder($query);
    }
}
