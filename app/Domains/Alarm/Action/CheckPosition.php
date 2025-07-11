<?php declare(strict_types=1);

namespace App\Domains\Alarm\Action;

use App\Domains\Alarm\Model\Alarm as Model;
use App\Domains\Alarm\Model\AlarmVehicle as AlarmVehicleModel;
use App\Domains\Alarm\Model\Collection\Alarm as Collection;
use App\Domains\Alarm\Service\Type\Manager as TypeManager;
use App\Domains\AlarmNotification\Job\Notify as AlarmNotificationNotifyJob;
use App\Domains\AlarmNotification\Model\AlarmNotification as AlarmNotificationModel;
use App\Domains\Position\Model\Position as PositionModel;
use App\Domains\Vehicle\Model\Vehicle as VehicleModel;

class CheckPosition extends ActionAbstract
{
    /**
     * @var \App\Domains\Alarm\Service\Type\Manager
     */
    protected TypeManager $manager;

    /**
     * @var \App\Domains\Position\Model\Position
     */
    protected PositionModel $position;

    /**
     * @var \App\Domains\Vehicle\Model\Vehicle
     */
    protected VehicleModel $vehicle;

    /**
     * @var array
     */
    protected array $states = [];

    /**
     * @var array
     */
    protected array $lastNotifications = [];

    /**
     * @return void
     */
    public function handle(): void
    {
        $this->manager();
        $this->position();
        $this->vehicle();
        $this->iterate();
        $this->save();
    }

    /**
     * @return void
     */
    protected function manager(): void
    {
        $this->manager = new TypeManager();
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
    protected function iterate(): void
    {
        foreach ($this->list() as $row) {
            $this->check($row);
        }
    }

    /**
     * @return \App\Domains\Alarm\Model\Collection\Alarm
     */
    protected function list(): Collection
    {
        return Model::query()
            ->enabled()
            ->byVehicleIdEnabled($this->vehicle->id)
            ->withVehiclePivot($this->vehicle->id)
            ->withNotificationLastClosedAtByVehicleId($this->vehicle->id)
            ->get();
    }

    /**
     * @param \App\Domains\Alarm\Model\Alarm $row
     *
     * @return void
     */
    protected function check(Model $row): void
    {
        $state = $this->checkState($row);

        if (($state === null) || ($state === $row->vehiclePivot->state)) {
            return;
        }

        $this->checkStateSave($row, $state);

        if ($state === false) {
            return;
        }

        if ($this->checkLast($row) === false) {
            return;
        }

        $this->checkSave($row);
    }

    /**
     * @param \App\Domains\Alarm\Model\Alarm $row
     *
     * @return ?bool
     */
    protected function checkState(Model $row): ?bool
    {
        return $this->manager->factory($row->type, $row->config)->state($this->position);
    }

    /**
     * @param \App\Domains\Alarm\Model\Alarm $row
     * @param bool $state
     *
     * @return void
     */
    protected function checkStateSave(Model $row, bool $state): void
    {
        $this->states[] = [
            'alarm_id' => $row->id,
            'vehicle_id' => $this->vehicle->id,
            'state' => $state,
        ];
    }

    /**
     * @param \App\Domains\Alarm\Model\Alarm $row
     *
     * @return bool
     */
    protected function checkLast(Model $row): bool
    {
        return empty($row->notificationLast) || $row->notificationLast->closed_at;
    }

    /**
     * @param \App\Domains\Alarm\Model\Alarm $row
     *
     * @return void
     */
    protected function checkSave(Model $row): void
    {
        $this->checkSaveJob($this->checkSaveNotification($row));
    }

    /**
     * @param \App\Domains\Alarm\Model\Alarm $row
     *
     * @return \App\Domains\AlarmNotification\Model\AlarmNotification
     */
    protected function checkSaveNotification(Model $row): AlarmNotificationModel
    {
        return AlarmNotificationModel::query()->create([
            'name' => $row->name,
            'type' => $row->type,
            'config' => $row->config,

            'telegram' => $row->telegram,

            'point' => AlarmNotificationModel::pointFromLatitudeLongitude($this->position->latitude, $this->position->longitude),

            'date_at' => $this->position->date_at,
            'date_utc_at' => $this->position->date_utc_at,

            'alarm_id' => $row->id,
            'position_id' => $this->position->id,
            'trip_id' => $this->position->trip->id,
            'vehicle_id' => $this->vehicle->id,
        ]);
    }

    /**
     * @param \App\Domains\AlarmNotification\Model\AlarmNotification $notification
     *
     * @return void
     */
    protected function checkSaveJob(AlarmNotificationModel $notification): void
    {
        AlarmNotificationNotifyJob::dispatch($notification->id);
    }

    /**
     * @return void
     */
    protected function save(): void
    {
        $this->saveStates();
    }

    /**
     * @return void
     */
    protected function saveStates(): void
    {
        if (empty($this->states)) {
            return;
        }

        AlarmVehicleModel::query()->upsert($this->states, ['alarm_id', 'vehicle_id'], ['state']);
    }
}
