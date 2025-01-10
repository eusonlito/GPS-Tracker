<?php declare(strict_types=1);

namespace App\Domains\Server\Test\Unit;

use App\Domains\Device\Model\Device as DeviceModel;
use App\Domains\Position\Model\Position as PositionModel;
use App\Domains\Trip\Model\Trip as TripModel;

class LogReadTeltonika extends UnitAbstract
{
    /**
     * @return void
     */
    public function testSuccess(): void
    {
        $this->authUser();

        $this->setCurl();
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
    protected function setDevice(): void
    {
        $this->factoryCreate(DeviceModel::class, ['serial' => '865282040403964']);
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
            'protocol' => 'teltonika',
            'file' => 'resources/app/test/server/teltonika.log',
        ];
    }

    /**
     * @return void
     */
    protected function checkTrip(): void
    {
        $this->assertEquals(1, TripModel::query()->count());

        $trip = TripModel::query()->first();

        $this->assertEquals('2025-01-10 14:23:12', $trip->start_utc_at);
        $this->assertEquals('2025-01-10 14:48:07', $trip->end_utc_at);
        $this->assertEquals(11680, $trip->distance);
        $this->assertEquals(1495, $trip->time);
        $this->assertEquals('{"time": {"total": 1495, "stopped": 334, "movement": 1161, "total_percent": 100, "stopped_percent": 22, "movement_percent": 78}, "speed": {"avg": 28.13, "max": 93, "min": 0, "avg_percent": 30, "max_percent": 100, "min_percent": 0, "avg_movement": 36.22, "avg_movement_percent": 39}}', $trip->getRawOriginal('stats'));
    }

    /**
     * @return void
     */
    protected function checkPosition(): void
    {
        $this->assertEquals(244, PositionModel::query()->count());

        $position = PositionModel::query()->orderByFirst()->first();

        $this->assertEquals(19.0, $position->speed);
        $this->assertEquals(77, $position->direction);
        $this->assertEquals(23, $position->signal);
        $this->assertEquals('2025-01-10 14:23:37', $position->date_utc_at);
        $this->assertEquals(-7.88184, $position->longitude);
        $this->assertEquals(42.31778, $position->latitude);

        $position = PositionModel::query()->orderByLast()->first();

        $this->assertEquals(6.0, $position->speed);
        $this->assertEquals(2, $position->direction);
        $this->assertEquals(18, $position->signal);
        $this->assertEquals('2025-01-10 14:48:07', $position->date_utc_at);
        $this->assertEquals(-7.88272, $position->longitude);
        $this->assertEquals(42.31537, $position->latitude);
    }
}
