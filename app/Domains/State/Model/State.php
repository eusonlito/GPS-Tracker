<?php declare(strict_types=1);

namespace App\Domains\State\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Domains\State\Model\Builder\State as Builder;
use App\Domains\Country\Model\Country as CountryModel;
use App\Domains\SharedApp\Model\ModelAbstract;

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
     * @param \Illuminate\Database\Query\Builder $q
     *
     * @return \App\Domains\State\Model\Builder\State
     */
    public function newEloquentBuilder($q): Builder
    {
        return new Builder($q);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo(CountryModel::class, CountryModel::FOREIGN)->withDefault();
    }
}
