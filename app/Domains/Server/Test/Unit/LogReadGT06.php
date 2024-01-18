<?php declare(strict_types=1);

namespace App\Domains\Server\Test\Unit;

use App\Domains\Device\Model\Device as DeviceModel;
use App\Domains\Position\Model\Position as PositionModel;
use App\Domains\Trip\Model\Trip as TripModel;

class LogReadGT06 extends UnitAbstract
{
    /**
     * @return void
     */
    public function testSuccess(): void
    {
        $this->authUser();

        $this->setCurl();
        $this->setConfiguration();
        $this->setDevice();
        $this->setAction();

        $this->checkTrip();
        $this->checkPosition();
    }

    /**
     * @return void
     */
    protected function setCurl(): void
    {
        $this->curlFake('resources/app/test/server/curl-nominatim.openstreetmap.org.log');
    }

    /**
     * @return void
     */
    protected function setConfiguration(): void
    {
        $this->factory('Configuration')->action()->request();
    }

    /**
     * @return void
     */
    protected function setDevice(): void
    {
        $this->factoryCreate(DeviceModel::class, ['serial' => '0865282040403964']);
    }

    /**
     * @return void
     */
    protected function setAction(): void
    {
        $this->factory()->action($this->setActionData())->logRead();
    }

    /**
     * @return array
     */
    protected function setActionData(): array
    {
        return [
            'protocol' => 'gt06',
            'file' => 'resources/app/test/server/gt06.log',
        ];
    }

    /**
     * @return void
     */
    protected function checkTrip(): void
    {
        $this->assertEquals(TripModel::query()->count(), 1);

        $trip = TripModel::query()->first();

        $this->assertEquals($trip->start_utc_at, '2023-12-28 10:04:06');
        $this->assertEquals($trip->end_utc_at, '2023-12-28 10:04:56');
        $this->assertEquals($trip->distance, 264);
        $this->assertEquals($trip->time, 50);
        $this->assertEquals($trip->getRawOriginal('stats'), '{"time": {"total": 50, "stopped": 12, "movement": 38, "total_percent": 100, "stopped_percent": 24, "movement_percent": 76}, "speed": {"avg": 19.01, "max": 50, "min": 0, "avg_percent": 38, "max_percent": 100, "min_percent": 0, "avg_movement": 25.01, "avg_movement_percent": 50}}');
    }

    /**
     * @return void
     */
    protected function checkPosition(): void
    {
        $this->assertEquals(PositionModel::query()->count(), 10);

        $position = PositionModel::query()->orderByFirst()->first();

        $this->assertEquals($position->speed, 0.00);
        $this->assertEquals($position->direction, 233);
        $this->assertEquals($position->signal, 1);
        $this->assertEquals($position->date_utc_at, '2023-12-28 10:04:06');
        $this->assertEquals($position->longitude, 15.92008);
        $this->assertEquals($position->latitude, 43.70989);

        $position = PositionModel::query()->orderByLast()->first();

        $this->assertEquals($position->speed, 42.6);
        $this->assertEquals($position->direction, 82);
        $this->assertEquals($position->signal, 1);
        $this->assertEquals($position->date_utc_at, '2023-12-28 10:04:56');
        $this->assertEquals($position->longitude, 15.92213);
        $this->assertEquals($position->latitude, 43.70845);
    }
}
