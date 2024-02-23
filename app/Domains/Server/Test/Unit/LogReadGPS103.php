<?php declare(strict_types=1);

namespace App\Domains\Server\Test\Unit;

use App\Domains\Device\Model\Device as DeviceModel;
use App\Domains\Position\Model\Position as PositionModel;
use App\Domains\Trip\Model\Trip as TripModel;

class LogReadGPS103 extends UnitAbstract
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
        $this->factoryCreate(DeviceModel::class, ['serial' => '1234567890']);
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
            'protocol' => 'gps103',
            'file' => 'resources/app/test/server/gps103.log',
        ];
    }

    /**
     * @return void
     */
    protected function checkTrip(): void
    {
        $this->assertEquals(1, TripModel::query()->count());

        $trip = TripModel::query()->first();

        $this->assertEquals('2024-01-17 19:19:55', $trip->start_utc_at);
        $this->assertEquals('2024-01-17 19:49:52', $trip->end_utc_at);
        $this->assertEquals(12401, $trip->distance);
        $this->assertEquals(1797, $trip->time);
        $this->assertEquals('{"time": {"total": 1797, "stopped": 437, "movement": 1360, "total_percent": 100, "stopped_percent": 24, "movement_percent": 76}, "speed": {"avg": 24.84, "max": 55.82, "min": 0, "avg_percent": 45, "max_percent": 100, "min_percent": 0, "avg_movement": 32.83, "avg_movement_percent": 59}}', $trip->getRawOriginal('stats'));
    }

    /**
     * @return void
     */
    protected function checkPosition(): void
    {
        $this->assertEquals(165, PositionModel::query()->count());

        $position = PositionModel::query()->orderByFirst()->first();

        $this->assertEquals(0.00, $position->speed);
        $this->assertEquals(79, $position->direction);
        $this->assertEquals(1, $position->signal);
        $this->assertEquals('2024-01-17 19:19:55', $position->date_utc_at);
        $this->assertEquals(49.74266, $position->longitude);
        $this->assertEquals(34.10137, $position->latitude);

        $position = PositionModel::query()->orderByLast()->first();

        $this->assertEquals(0.00, $position->speed);
        $this->assertEquals(92, $position->direction);
        $this->assertEquals(1, $position->signal);
        $this->assertEquals('2024-01-17 19:49:52', $position->date_utc_at);
        $this->assertEquals(49.74265, $position->longitude);
        $this->assertEquals(34.1014, $position->latitude);
    }
}
