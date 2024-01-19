<?php declare(strict_types=1);

namespace App\Services\Gpx;

use DateTime;
use DateTimeZone;
use phpGPX\Models\Extensions;
use phpGPX\Models\Extensions\TrackPointExtension;
use phpGPX\Models\GpxFile;
use phpGPX\Models\Metadata;
use phpGPX\Models\Point;
use phpGPX\Models\Segment;
use phpGPX\Models\Track;
use App\Domains\Position\Model\Collection\Position as PositionCollection;
use App\Domains\Position\Model\Position as PositionModel;
use App\Domains\Trip\Model\Trip as TripModel;

class Write
{
    /**
     * @var \phpGPX\Models\GpxFile
     */
    protected GpxFile $gpx;

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
        $this->gpx();
        $this->track();

        return $this;
    }

    /**
     * @return string
     */
    public function toXml(): string
    {
        return $this->gpx->toXML()->saveXML();
    }

    /**
     * @return self
     */
    protected function gpx(): self
    {
        $this->gpx = new GpxFile();
        $this->gpx->metadata = new Metadata();
        $this->gpx->metadata->time = $this->datetime($this->trip->start_at, $this->trip->timezone->zone);
        $this->gpx->metadata->description = $this->trip->name;

        return $this;
    }

    /**
     * @return self
     */
    protected function track(): self
    {
        $track = new Track();
        $track->name = $this->trip->name;
        $track->source = 'eusonlito/GPS-Tracker';

        $segment = new Segment();

        foreach ($this->positions() as $position) {
            $segment->points[] = $this->point($position);
        }

        $track->segments[] = $segment;
        $track->recalculateStats();

        $this->gpx->tracks[] = $track;

        return $this;
    }

    /**
     * @return \App\Domains\Position\Model\Collection\Position
     */
    protected function positions(): PositionCollection
    {
        return $this->trip
            ->positions()
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

        $trackPointExtension = new TrackPointExtension();
        $trackPointExtension->speed = $position->speed;
        $trackPointExtension->course = $position->direction;

        $extensions = new Extensions();
        $extensions->trackPointExtension = $trackPointExtension;

        $point->extensions = $extensions;

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
