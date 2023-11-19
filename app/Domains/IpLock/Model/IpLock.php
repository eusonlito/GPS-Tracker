<?php declare(strict_types=1);

namespace App\Domains\IpLock\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Domains\IpLock\Model\Builder\IpLock as Builder;
use App\Domains\IpLock\Model\Collection\IpLock as Collection;
use App\Domains\IpLock\Test\Factory\IpLock as TestFactory;
use App\Domains\CoreApp\Model\ModelAbstract;

class IpLock extends ModelAbstract
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'ip_lock';

    /**
     * @const string
     */
    public const TABLE = 'ip_lock';

    /**
     * @const string
     */
    public const FOREIGN = 'ip_lock_id';

    /**
     * @param array $models
     *
     * @return \App\Domains\IpLock\Model\Collection\IpLock
     */
    public function newCollection(array $models = []): Collection
    {
        return new Collection($models);
    }

    /**
     * @param \Illuminate\Database\Query\Builder $query
     *
     * @return \App\Domains\IpLock\Model\Builder\IpLock
     */
    public function newEloquentBuilder($query): Builder
    {
        return new Builder($query);
    }

    /**
     * @return \App\Domains\IpLock\Test\Factory\IpLock
     */
    protected static function newFactory(): TestFactory
    {
        return TestFactory::new();
    }

    /**
     * @return string
     */
    public function time(): string
    {
        if (empty($this->end_at)) {
            return '-';
        }

        return helper()->timeHuman(strtotime($this->end_at) - strtotime($this->created_at));
    }

    /**
     * @return bool
     */
    public function finished(): bool
    {
        return $this->end_at
            && ($this->end_at <= date('Y-m-d H:i:s'));
    }
}
