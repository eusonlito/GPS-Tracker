<?php declare(strict_types=1);

namespace App\Domains\State\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Domains\Country\Model\Country as CountryModel;
use App\Domains\SharedApp\Model\ModelAbstract;
use App\Domains\State\Model\Builder\State as Builder;
use App\Domains\State\Model\Collection\State as Collection;

class State extends ModelAbstract
{
    /**
     * @var string
     */
    protected $table = 'state';

    /**
     * @const string
     */
    public const TABLE = 'state';

    /**
     * @const string
     */
    public const FOREIGN = 'state_id';

    /**
     * @param array $models
     *
     * @return \App\Domains\State\Model\Collection\State
     */
    public function newCollection(array $models = []): Collection
    {
        return new Collection($models);
    }

    /**
     * @param \Illuminate\Database\Query\Builder $query
     *
     * @return \App\Domains\State\Model\Builder\State
     */
    public function newEloquentBuilder($query): Builder
    {
        return new Builder($query);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo(CountryModel::class, CountryModel::FOREIGN)->withDefault();
    }
}
