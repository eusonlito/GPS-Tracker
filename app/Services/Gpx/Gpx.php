<?php declare(strict_types=1);

namespace App\Services\Gpx;

use DateTime;
use DateTimeZone;
use Illuminate\Support\Collection;
use phpGPX\Models\GpxFile;
use phpGPX\Models\Metadata;
use phpGPX\Models\Point;
use phpGPX\Models\Segment;
use phpGPX\Models\Track;
use App\Domains\Position\Model\Position as PositionModel;
use App\Domains\Trip\Model\Trip as TripModel;

class Gpx
{
    /**
     * @var \phpGPX\Models\GpxFile
     */
    protected GpxFile $file;

    /**
     * @return self
     */
    public static function new(): self
    {
        return new static(...func_get_args());
    }

    /**
     * @param \App\Domains\Trip\Model\Trip $trip
     *
     * @return self
     */
    public function __construct(protected TripModel $trip)
    {
    }

    /**
     * @return self
     */
    public function generate(): self
    {
        $this->file();
        $this->track();

        return $this;
    }

    /**
     * @return string
     */
    public function toXml(): string
    {
        return $this->file->toXML()->saveXML();
    }

    /**
     * @return self
     */
    protected function file(): self
    {
        $this->file = new GpxFile();
        $this->file->metadata = new Metadata();
        $this->file->metadata->time = $this->datetime($this->trip->start_at, $this->trip->timezone->zone);

        return $this;
    }

    /**
     * @return self
     */
    protected function track(): self
    {
        $track = new Track();
        $track->name = $this->trip->name;

        $segment = new Segment();

        foreach ($this->positions() as $position) {
            $segment->points[] = $this->point($position);
        }

        $track->segments[] = $segment;
        $track->recalculateStats();

        $this->file->tracks[] = $track;

        return $this;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    protected function positions(): Collection
    {
        static $cache;

        return $cache ??= $this->trip->positions()
            ->orderByDateUtcAtAsc()
            ->withTimezone()
            ->get();
    }

    /**
     * @param \App\Domains\Position\Model\Position $position
     *
     * @return \phpGPX\Models\Point
     */
    protected function point(PositionModel $position): Point
    {
        $point = new Point(Point::TRACKPOINT);
        $point->latitude = $position->latitude;
        $point->longitude = $position->longitude;
        $point->time = $this->datetime($position->date_at, $position->timezone->zone);

        return $point;
    }

    /**
     * @param string $date
     * @param string $timezone
     *
     * @return \DateTime
     */
    protected function datetime(string $date, string $timezone): DateTime
    {
        return new DateTime($date, new DateTimeZone($timezone));
    }
}
