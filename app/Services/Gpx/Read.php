<?php declare(strict_types=1);

namespace App\Services\Gpx;

use phpGPX\phpGPX;
use phpGPX\Models\GpxFile;
use phpGPX\Models\Point;

class Read
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
     * @param string $file
     *
     * @return self
     */
    public function __construct(protected string $file)
    {
        $this->gpx = (new phpGPX())->load($this->file);
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->map($this->sort($this->getPoints()));
    }

    /**
     * @return array
     */
    protected function getPoints(): array
    {
        $points = [];

        foreach ($this->gpx->tracks as $track) {
            foreach ($track->segments as $segment) {
                foreach ($segment->points as $point) {
                    if ($this->pointIsValid($point)) {
                        $points[] = $point;
                    }
                }
            }
        }

        return $points;
    }

    /**
     * @param \phpGPX\Models\Point $point
     *
     * @return bool
     */
    protected function pointIsValid(Point $point): bool
    {
        return $point->latitude
            && $point->longitude
            && $point->time;
    }

    /**
     * @param array $points
     *
     * @return array
     */
    protected function sort(array $points): array
    {
        usort($points, static fn ($a, $b) => $a->time->getTimestamp() <=> $b->time->getTimestamp());

        return $points;
    }

    /**
     * @param array $points
     *
     * @return array
     */
    protected function map(array $points): array
    {
        $data = [];

        foreach ($points as $i => $point) {
            $data[] = $this->mapPoint($point, $points[$i - 1] ?? null, $points[$i + 1] ?? null);
        }

        return $data;
    }

    /**
     * @param \phpGPX\Models\Point $point
     * @param ?\phpGPX\Models\Point $previous
     * @param ?\phpGPX\Models\Point $next
     *
     * @return array
     */
    protected function mapPoint(Point $point, ?Point $previous, ?Point $next): array
    {
        return [
            'latitude' => $point->latitude,
            'longitude' => $point->longitude,
            'timestamp' => $point->time->getTimestamp(),
            'speed' => $this->mapPointSpeed($point, $previous),
            'direction' => $this->mapPointDirection($point, $previous, $next),
        ];
    }

    /**
     * @param \phpGPX\Models\Point $point
     * @param ?\phpGPX\Models\Point $previous
     *
     * @return float
     */
    protected function mapPointSpeed(Point $point, ?Point $previous): float
    {
        if ($speed = $point->extensions->trackPointExtension?->speed) {
            return $speed;
        }

        if ($previous === null) {
            return 0;
        }

        $distance = helper()->coordinatesDistance(
            $previous->latitude,
            $previous->longitude,
            $point->latitude,
            $point->longitude,
        );

        $time = $point->time->getTimestamp() - $previous->time->getTimestamp();

        return round($distance / $time * 3.6, 2);
    }

    /**
     * @param \phpGPX\Models\Point $point
     * @param ?\phpGPX\Models\Point $previous
     * @param ?\phpGPX\Models\Point $next
     *
     * @return int
     */
    protected function mapPointDirection(Point $point, ?Point $previous, ?Point $next): int
    {
        if ($course = $point->extensions->trackPointExtension?->course) {
            return $course;
        }

        if ($next) {
            return helper()->coordinatesDirection(
                $point->latitude,
                $point->longitude,
                $next->latitude,
                $next->longitude,
            );
        }

        if ($previous) {
            return helper()->coordinatesDirection(
                $previous->latitude,
                $previous->longitude,
                $point->latitude,
                $point->longitude,
            );
        }

        return 0;
    }
}
