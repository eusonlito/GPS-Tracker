<?php declare(strict_types=1);

namespace App\Domains\Server\Test\Unit;

use App\Domains\Device\Model\Device as DeviceModel;
use App\Domains\Position\Model\Position as PositionModel;
use App\Domains\Trip\Model\Trip as TripModel;

class LogReadOsmAnd extends UnitAbstract
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
            'protocol' => 'osmand',
            'file' => 'resources/app/test/server/osmand.log',
        ];
    }

    /**
     * @return void
     */
    protected function checkTrip(): void
    {
        $this->assertEquals(1, TripModel::query()->count());

        $trip = TripModel::query()->first();

        $this->assertEquals('2023-05-25 16:24:25', $trip->start_utc_at);
        $this->assertEquals('2023-05-25 16:34:41', $trip->end_utc_at);
        $this->assertEquals(1940, $trip->distance);
        $this->assertEquals(616, $trip->time);
        $this->assertEquals('{"time": {"total": 616, "stopped": 308, "movement": 308, "total_percent": 100, "stopped_percent": 50, "movement_percent": 50}, "speed": {"avg": 11.34, "max": 46.04, "min": 0, "avg_percent": 25, "max_percent": 100, "min_percent": 0, "avg_movement": 22.68, "avg_movement_percent": 49}}', $trip->getRawOriginal('stats'));
    }

    /**
     * @return void
     */
    protected function checkPosition(): void
    {
        $this->assertEquals(37, PositionModel::query()->count());

        $position = PositionModel::query()->orderByFirst()->first();

        $this->assertEquals(2.41, $position->speed);
        $this->assertEquals(0, $position->direction);
        $this->assertEquals(1, $position->signal);
        $this->assertEquals('2023-05-25 16:24:25', $position->date_utc_at);
        $this->assertEquals(-7.87789, $position->longitude);
        $this->assertEquals(42.35242, $position->latitude);

        $position = PositionModel::query()->orderByLast()->first();

        $this->assertEquals(0.00, $position->speed);
        $this->assertEquals(215, $position->direction);
        $this->assertEquals(1, $position->signal);
        $this->assertEquals('2023-05-25 16:34:41', $position->date_utc_at);
        $this->assertEquals(-7.86748, $position->longitude);
        $this->assertEquals(42.35894, $position->latitude);
    }
}
