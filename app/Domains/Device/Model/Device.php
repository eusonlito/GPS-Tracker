<?php declare(strict_types=1);

namespace App\Domains\Device\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Domains\Device\Model\Builder\Device as Builder;
use App\Domains\Alarm\Model\Alarm as AlarmModel;
use App\Domains\Alarm\Model\AlarmDevice as AlarmDeviceModel;
use App\Domains\AlarmNotification\Model\AlarmNotification as AlarmNotificationModel;
use App\Domains\DeviceMessage\Model\DeviceMessage as DeviceMessageModel;
use App\Domains\SharedApp\Model\ModelAbstract;
use App\Domains\Timezone\Model\Timezone as TimezoneModel;
use App\Domains\Trip\Model\Trip as TripModel;
use App\Domains\User\Model\User as UserModel;

class Device extends ModelAbstract
{
    /**
     * @var string
     */
    protected $table = 'device';

    /**
     * @const string
     */
    public const TABLE = 'device';

    /**
     * @const string
     */
    public const FOREIGN = 'device_id';

    /**
     * @param \Illuminate\Database\Query\Builder $q
     *
     * @return \App\Domains\Device\Model\Builder\Device
     */
    public function newEloquentBuilder($q): Builder
    {
        return new Builder($q);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function alarmPivot(): HasOne
    {
        return $this->hasOne(AlarmDeviceModel::class, static::FOREIGN);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function alarms(): BelongsToMany
    {
        return $this->belongsToMany(AlarmModel::class, AlarmDeviceModel::TABLE);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function alarmsNotifications(): HasMany
    {
        return $this->hasMany(AlarmNotificationModel::class, static::FOREIGN);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function messages(): HasMany
    {
        return $this->hasMany(DeviceMessageModel::class, static::FOREIGN);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function timezone(): BelongsTo
    {
        return $this->belongsTo(TimezoneModel::class, TimezoneModel::FOREIGN);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function trips(): HasMany
    {
        return $this->hasMany(TripModel::class, static::FOREIGN);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(UserModel::class, UserModel::FOREIGN);
    }
}
