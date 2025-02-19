<?php

declare(strict_types=1);

namespace App\Domains\Role\Action;

use App\Domains\Role\Model\Role as Model;
use App\Domains\Role\Model\Collection\Role as Collection;
use App\Domains\RoleNotification\Job\Notify as RoleNotificationNotifyJob;
use App\Domains\RoleNotification\Model\RoleNotification as RoleNotificationModel;
use App\Domains\Position\Model\Position as PositionModel;
use App\Domains\Vehicle\Model\Vehicle as VehicleModel;

class CheckPosition extends ActionAbstract
{
    /**
     * @var \App\Domains\Position\Model\Position
     */
    protected PositionModel $position;

    /**
     * @var \App\Domains\Vehicle\Model\Vehicle
     */
    protected VehicleModel $vehicle;

    /**
     * @return void
     */
    public function handle(): void
    {
        $this->position();
        $this->vehicle();
        $this->data();
        $this->iterate();
    }

    /**
     * @return void
     */
    protected function position(): void
    {
        $this->position = PositionModel::query()
            ->withVehicle()
            ->withTrip()
            ->findOrFail($this->data['position_id']);
    }

    /**
     * @return void
     */
    protected function vehicle(): void
    {
        $this->vehicle = $this->position->vehicle;
    }

    /**
     * @return void
     */
    protected function data(): void
    {
        $this->dataLatitude();
        $this->dataLongitude();
        $this->dataSpeed();
    }

    /**
     * @return void
     */
    protected function dataLatitude(): void
    {
        $this->data['latitude'] = $this->position->latitude;
    }

    /**
     * @return void
     */
    protected function dataLongitude(): void
    {
        $this->data['longitude'] = $this->position->longitude;
    }

    /**
     * @return void
     */
    protected function dataSpeed(): void
    {
        $this->data['speed'] = match ($this->position->user->preferences['units']['distance'] ?? 'kilometer') {
            'knot' => $this->position->speed * 0.539957,
            'mile' => $this->position->speed * 0.621371,
            default => $this->position->speed,
        };
    }

    /**
     * @return void
     */
    protected function iterate(): void
    {
        foreach ($this->list() as $row) {
            $this->check($row);
        }
    }

    /**
     * @return \App\Domains\Role\Model\Collection\Role
     */
    protected function list(): Collection
    {
        return Model::query()
            ->byVehicleIdEnabled($this->vehicle->id)
            ->bySchedule(explode(' ', $this->position->date_at)[1])
            ->check($this->data['latitude'], $this->data['longitude'], $this->data['speed'])
            ->enabled()
            ->get();
    }

    /**
     * @param \App\Domains\Role\Model\Role $row
     *
     * @return void
     */
    protected function check(Model $row): void
    {
        if ($this->checkLast($row) === false) {
            return;
        }

        $this->save($row);
    }

    /**
     * @param \App\Domains\Role\Model\Role $row
     *
     * @return bool
     */
    protected function checkLast(Model $row): bool
    {
        $notification = RoleNotificationModel::query()
            ->selectOnly('closed_at')
            ->byRoleId($row->id)
            ->orderByLast()
            ->first();

        return empty($notification) || $notification->closed_at;
    }

    /**
     * @param \App\Domains\Role\Model\Role $row
     *
     * @return void
     */
    protected function save(Model $row): void
    {
        $this->saveJob($this->saveNotification($row));
    }

    /**
     * @param \App\Domains\Role\Model\Role $row
     *
     * @return \App\Domains\RoleNotification\Model\RoleNotification
     */
    protected function saveNotification(Model $row): RoleNotificationModel
    {
        return RoleNotificationModel::query()->create([
            'name' => $row->name,
            'type' => $row->type,
            'config' => $row->config,

            'telegram' => $row->telegram,

            'point' => RoleNotificationModel::pointFromLatitudeLongitude($this->position->latitude, $this->position->longitude),

            'date_at' => $this->position->date_at,
            'date_utc_at' => $this->position->date_utc_at,

            'Role_id' => $row->id,
            'position_id' => $this->position->id,
            'trip_id' => $this->position->trip->id,
            'vehicle_id' => $this->vehicle->id,
        ]);
    }

    /**
     * @param \App\Domains\RoleNotification\Model\RoleNotification $notification
     *
     * @return void
     */
    protected function saveJob(RoleNotificationModel $notification): void
    {
        RoleNotificationNotifyJob::dispatch($notification->id);
    }
}
