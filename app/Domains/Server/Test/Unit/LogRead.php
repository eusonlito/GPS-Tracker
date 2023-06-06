<?php declare(strict_types=1);

namespace App\Domains\Server\Test\Unit;

use App\Domains\Device\Model\Device as DeviceModel;
use App\Domains\Position\Model\Position as PositionModel;
use App\Domains\Trip\Model\Trip as TripModel;
use App\Services\Http\Curl\Curl;

class LogRead extends UnitAbstract
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
        Curl::fake(file_get_contents(base_path('resources/app/test/server/curl-nominatim.openstreetmap.org.log')));
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
            'protocol' => 'h02',
            'file' => 'resources/app/test/server/2023-05-25.log',
        ];
    }

    /**
     * @return void
     */
    protected function checkTrip(): void
    {
        $this->assertEquals(TripModel::query()->count(), 1);

        $trip = TripModel::query()->first();

        $this->assertEquals($trip->start_utc_at, '2023-05-25 16:24:25');
        $this->assertEquals($trip->end_utc_at, '2023-05-25 16:30:23');
        $this->assertEquals($trip->distance, 1935);
        $this->assertEquals($trip->time, 358);
        $this->assertEquals($trip->getRawOriginal('stats'), '{"time": {"total": 358, "stopped": 50, "movement": 308, "total_percent": 100, "stopped_percent": 14, "movement_percent": 86}, "speed": {"avg": 19.46, "max": 46.04, "min": 0, "avg_percent": 42, "max_percent": 100, "min_percent": 0, "avg_movement": 22.62, "avg_movement_percent": 49}}');
    }

    /**
     * @return void
     */
    protected function checkPosition(): void
    {
        $this->assertEquals(PositionModel::query()->count(), 36);

        $position = PositionModel::query()->orderByFirst()->first();

        $this->assertEquals($position->speed, 2.41);
        $this->assertEquals($position->direction, 0);
        $this->assertEquals($position->signal, 1);
        $this->assertEquals($position->date_utc_at, '2023-05-25 16:24:25');
        $this->assertEquals($position->longitude, -7.87789);
        $this->assertEquals($position->latitude, 42.35242);

        $position = PositionModel::query()->orderByLast()->first();

        $this->assertEquals($position->speed, 0.00);
        $this->assertEquals($position->direction, 215);
        $this->assertEquals($position->signal, 1);
        $this->assertEquals($position->date_utc_at, '2023-05-25 16:30:23');
        $this->assertEquals($position->longitude, -7.86745);
        $this->assertEquals($position->latitude, 42.35898);
    }
}
