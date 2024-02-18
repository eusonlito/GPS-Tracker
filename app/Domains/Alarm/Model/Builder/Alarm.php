<?php declare(strict_types=1);

namespace App\Domains\Alarm\Model\Builder;

use App\Domains\Alarm\Model\AlarmVehicle as AlarmVehicleModel;
use App\Domains\CoreApp\Model\Builder\BuilderAbstract;

class Alarm extends BuilderAbstract
{
    /**
     * @param float $latitude
     * @param float $longitude
     * @param float $speed
     *
     * @return self
     */
    public function check(float $latitude, float $longitude, float $speed): self
    {
        return $this->where(
            fn ($q) => $q
                ->orWhere(fn ($q) => $q->checkFenceIn($latitude, $longitude))
                ->orWhere(fn ($q) => $q->checkFenceOut($latitude, $longitude))
                ->orWhere(fn ($q) => $q->checkMovement($speed))
                ->orWhere(fn ($q) => $q->checkVibration())
                ->orWhere(fn ($q) => $q->checkOverspeed($speed))
                ->orWhere(fn ($q) => $q->checkPolygonIn($latitude, $longitude))
                ->orWhere(fn ($q) => $q->checkPolygonOut($latitude, $longitude))
        );
    }

    /**
     * @param float $latitude
     * @param float $longitude
     *
     * @return self
     */
    public function checkFenceIn(float $latitude, float $longitude): self
    {
        return $this->byType('fence-in')
            ->whereRaw(sprintf(
                $this->checkFenceInSql(),
                helper()->longitude($longitude),
                helper()->latitude($latitude)
            ));
    }

    /**
     * @return string
     */
    protected function checkFenceInSql(): string
    {
        return <<<'EOT'
            ST_Contains(
                ST_Buffer(
                    ST_SRID(POINT(`config`->'$.longitude', `config`->'$.latitude'), 4326),
                    `config`->'$.radius' * 1000
                ),
                ST_SRID(POINT(%f, %f), 4326)
            )
            EOT;
    }

    /**
     * @param float $latitude
     * @param float $longitude
     *
     * @return self
     */
    public function checkFenceOut(float $latitude, float $longitude): self
    {
        return $this->byType('fence-out')
            ->whereRaw(sprintf(
                $this->checkFenceOutSql(),
                helper()->longitude($longitude),
                helper()->latitude($latitude)
            ));
    }

    /**
     * @return string
     */
    protected function checkFenceOutSql(): string
    {
        return <<<'EOT'
            ST_Contains(
                ST_Buffer(
                    ST_SRID(POINT(`config`->'$.longitude', `config`->'$.latitude'), 4326),
                    `config`->'$.radius' * 1000
                ),
                ST_SRID(POINT(%f, %f), 4326)
            ) = FALSE
            EOT;
    }

    /**
     * @param float $speed
     *
     * @return self
     */
    public function checkMovement(float $speed): self
    {
        return $this->byType('movement')
            ->whereRaw(sprintf('%f > 0', $speed));
    }

    /**
     * @param float $speed
     *
     * @return self
     */
    public function checkOverspeed(float $speed): self
    {
        return $this->byType('overspeed')
            ->whereRaw(sprintf('%f > `config`->\'$.speed\'', $speed));
    }

    /**
     * @param float $latitude
     * @param float $longitude
     *
     * @return self
     */
    public function checkPolygonIn(float $latitude, float $longitude): self
    {
        return $this->byType('polygon-in')
            ->whereRaw(sprintf(
                $this->checkPolygonInSql(),
                helper()->longitude($longitude),
                helper()->latitude($latitude)
            ));
    }

    /**
     * @return string
     */
    protected function checkPolygonInSql(): string
    {
        return <<<'EOT'
            ST_Contains(
                ST_GeomFromGeoJSON(`config`->'$.geojson'),
                ST_SRID(POINT(%f, %f), 4326)
            )
            EOT;
    }

    /**
     * @param float $latitude
     * @param float $longitude
     *
     * @return self
     */
    public function checkPolygonOut(float $latitude, float $longitude): self
    {
        return $this->byType('polygon-out')
            ->whereRaw(sprintf(
                $this->checkPolygonOutSql(),
                helper()->longitude($longitude),
                helper()->latitude($latitude)
            ));
    }

    /**
     * @return string
     */
    protected function checkPolygonOutSql(): string
    {
        return <<<'EOT'
            ST_Contains(
                ST_GeomFromGeoJSON(`config`->'$.geojson'),
                ST_SRID(POINT(%f, %f), 4326)
            ) = FALSE
            EOT;
    }

    /**
     * @return self
     */
    public function checkVibration(): self
    {
        return $this->byType('vibration');
    }

    /**
     * @param string $time
     *
     * @return self
     */
    public function bySchedule(string $time): self
    {
        return $this->where(static function ($q) use ($time) {
            $q->where(fn ($q) => $q->whereScheduleIsEmpty())
                ->orWhere(fn ($q) => $q->byScheduleStart($time)->byScheduleEnd($time));
        });
    }

    /**
     * @param string $time
     *
     * @return self
     */
    public function byScheduleEnd(string $time): self
    {
        return $this->where('schedule_end', '>=', $time);
    }

    /**
     * @param string $time
     *
     * @return self
     */
    public function byScheduleStart(string $time): self
    {
        return $this->where('schedule_start', '<=', $time);
    }

    /**
     * @param string $type
     *
     * @return self
     */
    public function byType(string $type): self
    {
        return $this->where('type', $type);
    }

    /**
     * @param int $vehicle_id
     *
     * @return self
     */
    public function byVehicleId(int $vehicle_id): self
    {
        return $this->whereIn('id', AlarmVehicleModel::query()->selectOnly('alarm_id')->byVehicleId($vehicle_id));
    }

    /**
     * @param int $vehicle_id
     *
     * @return self
     */
    public function byVehicleIdEnabled(int $vehicle_id): self
    {
        return $this->whereIn('id', AlarmVehicleModel::query()->selectOnly('alarm_id')->byVehicleIdEnabled($vehicle_id));
    }

    /**
     * @param int $vehicle_id
     *
     * @return self
     */
    public function withVehiclePivot(int $vehicle_id): self
    {
        return $this->with(['vehiclePivot' => fn ($q) => $q->byVehicleId($vehicle_id)]);
    }

    /**
     * @param string $serial
     *
     * @return self
     */
    public function byVehicleSerial(string $serial): self
    {
        return $this->whereIn('id', AlarmVehicleModel::query()->selectOnly('alarm_id')->byVehicleSerial($serial));
    }

    /**
     * @return self
     */
    public function selectRelatedSimple(): self
    {
        return $this->select('id', 'name', 'type', 'enabled', 'user_id');
    }

    /**
     * @return self
     */
    public function whereScheduleIsEmpty(): self
    {
        return $this->whereScheduleStartIsEmpty()->whereScheduleEndIsEmpty();
    }

    /**
     * @return self
     */
    public function whereScheduleEndIsEmpty(): self
    {
        return $this->whereRaw('TRIM(COALESCE(`schedule_end`, "")) = ""');
    }

    /**
     * @return self
     */
    public function whereScheduleStartIsEmpty(): self
    {
        return $this->whereRaw('TRIM(COALESCE(`schedule_start`, "")) = ""');
    }

    /**
     * @return self
     */
    public function withVehicles(): self
    {
        return $this->with('vehicles');
    }

    /**
     * @return self
     */
    public function withVehiclesCount(): self
    {
        return $this->withCount('vehicles');
    }

    /**
     * @return self
     */
    public function withNotificationsCount(): self
    {
        return $this->withCount('notifications');
    }

    /**
     * @return self
     */
    public function withNotificationsPendingCount(): self
    {
        return $this->withCount([
            'notifications as notifications_pending_count' => fn ($q) => $q->whereClosedAt(false),
        ]);
    }
}
