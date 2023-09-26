<?php declare(strict_types=1);

namespace App\Domains\DeviceMessage\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Domains\Device\Model\Device as DeviceModel;
use App\Domains\DeviceMessage\Model\Builder\DeviceMessage as Builder;
use App\Domains\DeviceMessage\Model\Collection\DeviceMessage as Collection;
use App\Domains\DeviceMessage\Test\Factory\DeviceMessage as TestFactory;
use App\Domains\CoreApp\Model\ModelAbstract;

class DeviceMessage extends ModelAbstract
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'device_message';

    /**
     * @const string
     */
    public const TABLE = 'device_message';

    /**
     * @const string
     */
    public const FOREIGN = 'device_message_id';

    /**
     * @param array $models
     *
     * @return \App\Domains\DeviceMessage\Model\Collection\DeviceMessage
     */
    public function newCollection(array $models = []): Collection
    {
        return new Collection($models);
    }

    /**
     * @param \Illuminate\Database\Query\Builder $query
     *
     * @return \App\Domains\DeviceMessage\Model\Builder\DeviceMessage
     */
    public function newEloquentBuilder($query): Builder
    {
        return new Builder($query);
    }

    /**
     * @return \App\Domains\DeviceMessage\Test\Factory\DeviceMessage
     */
    protected static function newFactory(): TestFactory
    {
        return TestFactory::new();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function device(): BelongsTo
    {
        return $this->belongsTo(DeviceModel::class, DeviceModel::FOREIGN);
    }

    /**
     * @return string
     */
    public function message(): string
    {
        return strtr($this->message, [
            '{PASSWORD}' => $this->device->password,
            '{SERIAL}' => $this->device->serial,
        ]);
    }
}
