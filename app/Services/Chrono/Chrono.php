<?php declare(strict_types=1);

namespace App\Services\Chrono;

use InvalidArgumentException;

class Chrono
{
    /**
     * @var array
     */
    protected static array $chronos = [];

    /**
     * @param bool $memory = false
     */
    public static function reset(bool $memory = false): void
    {
        self::$chronos = [];

        if ($memory) {
            memory_reset_peak_usage();
        }
    }

    /**
     * @param string $name
     * @param mixed $data = null
     *
     * @return void
     */
    public static function start(string $name, mixed $data = null): void
    {
        self::$chronos[$name] ??= [
            'time_total' => 0,
            'time_average' => 0,
            'memory_average' => 0,
            'measures' => [],
        ];

        self::$chronos[$name]['measures'][] = [
            'action' => 'start',
            'time_absolute' => microtime(true),
            'memory_absolute' => round(memory_get_peak_usage(true) / 1024 / 1024, 4),
            'data' => $data,
        ];
    }

    /**
     * @param string $name
     * @param mixed $data = null
     *
     * @return void
     */
    public static function stop(string $name, mixed $data = null): void
    {
        if (empty(self::$chronos[$name])) {
            throw new InvalidArgumentException(sprintf('Chrono %s not started', $name));
        }

        $time = microtime(true);
        $previous = end(self::$chronos[$name]['measures']);
        $memory = round(memory_get_peak_usage(true) / 1024 / 1024, 4);

        self::$chronos[$name]['measures'][] = [
            'action' => 'stop',
            'time_absolute' => $time,
            'time_relative' => round($time - $previous['time_absolute'], 5),
            'memory_absolute' => $memory,
            'memory_relative' => round($memory - $previous['memory_absolute'], 4),
            'data' => $data,
            'previous' => $previous,
        ];
    }

    /**
     * @return array
     */
    public static function all(): array
    {
        return self::$chronos;
    }

    /**
     * @param ?string $sort = 'time_total'
     * @param bool $detail = false
     *
     * @return array
     */
    public static function summary(?string $sort = 'time_total', bool $detail = false): array
    {
        $chronos = [];

        foreach (array_keys(self::$chronos) as $name) {
            $chronos[$name] = static::chronoSummary($name, $detail);
        }

        $chronos = self::summaryPercent($chronos);

        if ($sort) {
            $chronos = self::summarySort($chronos, $sort);
        }

        return $chronos;
    }

    /**
     * @param array $chronos
     * @param string $sort
     *
     * @return array
     */
    protected static function summarySort(array $chronos, string $sort): array
    {
        if (in_array($sort, ['time_total', 'time_average', 'memory_average', 'measures_count']) === false) {
            throw new InvalidArgumentException(sprintf('Invalid sort %s', $sort));
        }

        uasort($chronos, static fn ($a, $b) => $b[$sort] <=> $a[$sort]);

        return $chronos;
    }

    /**
     * @param array $chronos
     *
     * @return array
     */
    protected static function summaryPercent(array $chronos): array
    {
        $time_total = max(array_column($chronos, 'time_total'));
        $memory_average = max(array_column($chronos, 'memory_average'));

        foreach ($chronos as &$value) {
            $value['time_total_percent'] = intval($value['time_total'] * 100 / $time_total);
            $value['memory_average_percent'] = intval($value['memory_average'] * 100 / $memory_average);
        }

        unset($value);

        return $chronos;
    }

    /**
     * @param string $name
     * @param bool $detail = false
     *
     * @return array
     */
    public static function chronoSummary(string $name, bool $detail = false): array
    {
        $chrono = self::$chronos[$name] ?? null;

        if (empty($chrono)) {
            throw new InvalidArgumentException(sprintf('Chrono %s not exists', $name));
        }

        $measures = array_filter(
            $chrono['measures'],
            static fn ($measure) => $measure['action'] === 'stop'
        );

        $time = array_sum(array_column($measures, 'time_relative'));
        $memory = array_sum(array_column($measures, 'memory_relative'));
        $count = count($measures) ?: 1;

        $summary = [
            'time_total' => $time,
            'time_average' => round($time / $count, 5),
            'memory_average' => round($memory / $count, 4),
            'measures_count' => $count,
        ];

        if ($detail) {
            $summary['measures'] = $chrono['measures'];
        }

        return $summary;
    }
}
