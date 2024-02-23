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
        $this->assertEquals(1, TripModel::query()->count());

        $trip = TripModel::query()->first();

        $this->assertEquals('2023-12-28 10:04:06', $trip->start_utc_at);
        $this->assertEquals('2023-12-28 10:04:56', $trip->end_utc_at);
        $this->assertEquals(264, $trip->distance);
        $this->assertEquals(50, $trip->time);
        $this->assertEquals('{"time": {"total": 50, "stopped": 12, "movement": 38, "total_percent": 100, "stopped_percent": 24, "movement_percent": 76}, "speed": {"avg": 19.01, "max": 50, "min": 0, "avg_percent": 38, "max_percent": 100, "min_percent": 0, "avg_movement": 25.01, "avg_movement_percent": 50}}', $trip->getRawOriginal('stats'));
    }

    /**
     * @return void
     */
    protected function checkPosition(): void
    {
        $this->assertEquals(10, PositionModel::query()->count());

        $position = PositionModel::query()->orderByFirst()->first();

        $this->assertEquals(0.00, $position->speed);
        $this->assertEquals(233, $position->direction);
        $this->assertEquals(1, $position->signal);
        $this->assertEquals('2023-12-28 10:04:06', $position->date_utc_at);
        $this->assertEquals(15.92008, $position->longitude);
        $this->assertEquals(43.70989, $position->latitude);

        $position = PositionModel::query()->orderByLast()->first();

        $this->assertEquals(42.6, $position->speed);
        $this->assertEquals(82, $position->direction);
        $this->assertEquals(1, $position->signal);
        $this->assertEquals('2023-12-28 10:04:56', $position->date_utc_at);
        $this->assertEquals(15.92213, $position->longitude);
        $this->assertEquals(43.70845, $position->latitude);
    }
}
