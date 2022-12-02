<?php declare(strict_types=1);

namespace App\Domains\Alarm\Model;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Domains\Device\Model\Device as DeviceModel;
use App\Domains\Alarm\Model\Builder\Alarm as Builder;
use App\Domains\Alarm\Model\Traits\TypeFormat as TypeFormatTrait;
use App\Domains\AlarmNotification\Model\AlarmNotification as AlarmNotificationModel;
use App\Domains\SharedApp\Model\ModelAbstract;

class Alarm extends ModelAbstract
{
    use TypeFormatTrait;

    /**
     * @var string
     */
    protected $table = 'alarm';

    /**
     * @const string
     */
    public const TABLE = 'alarm';

    /**
     * @const string
     */
    public const FOREIGN = 'alarm_id';

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'config' => 'array',
        'telegram' => 'boolean',
        'enabled' => 'boolean',
    ];

    /**
     * @param \Illuminate\Database\Query\Builder $q
     *
     * @return \App\Domains\Alarm\Model\Builder\Alarm
     */
    public function newEloquentBuilder($q): Builder
    {
        return new Builder($q);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function devicePivot(): HasOne
    {
        return $this->hasOne(AlarmDevice::class, static::FOREIGN);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function devices(): BelongsToMany
    {
        return $this->belongsToMany(DeviceModel::class, AlarmDevice::TABLE)->withTimeZone();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function notifications(): HasMany
    {
        return $this->hasMany(AlarmNotificationModel::class, static::FOREIGN);
    }
}
