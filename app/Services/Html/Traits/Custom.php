<?php declare(strict_types=1);

namespace App\Services\Html\Traits;

use App\Domains\Timezone\Model\Timezone as TimezoneModel;

trait Custom
{
    /**
     * @param string $name
     * @param string $class = ''
     *
     * @return string
     */
    public static function icon(string $name, string $class = ''): string
    {
        return '<svg class="feather '.$class.'"><use xlink:href="'.static::asset('build/images/feather-sprite.svg').'#'.$name.'" /></svg>';
    }

    /**
     * @param string $path
     * @param string $class = ''
     *
     * @return string
     */
    public static function svg(string $path, string $class = ''): string
    {
        return str_replace('class=""', 'class="'.$class.'"', static::inline($path));
    }

    /**
     * @param ?bool $status
     * @param string $text = ''
     * @param string $class = ''
     *
     * @return string
     */
    public static function status(?bool $status, string $text = '', string $class = ''): string
    {
        if ($status === null) {
            return '-';
        }

        if ($status) {
            $theme = 'text-theme-10';
            $icon = 'check-square';
        } else {
            $theme = 'text-theme-24';
            $icon = 'square';
        }

        return '<span class="'.$theme.'">'.($text ?: static::icon($icon, 'w-4 h-4 '.$class)).'</span>';
    }

    /**
     * @param float $percent
     * @param string $class = 'h-3'
     *
     * @return string
     */
    public static function progressbar(float $percent, string $class = 'h-3'): string
    {
        if ($percent >= 90) {
            $color = '#F15B38';
        } elseif ($percent >= 70) {
            $color = '#EDBE38';
        } else {
            $color = '#1E3A8A';
        }

        $html = trim('
            <div class="w-full bg-slate-200 rounded overflow-hidden :class">
                <div role="progressbar" aria-valuenow=":percent" aria-valuemin="0" aria-valuemax="100" class="h-full rounded flex justify-center items-center" style="background-color: :color; width: :percent%"></div>
            </div>
        ');

        return strtr($html, [
            ':class' => $class,
            ':percent' => $percent,
            ':color' => $color,
        ]);
    }

    /**
     * @param ?array $data
     * @param string $class = 'border text-slate-600'
     *
     * @return string
     */
    public static function arrayAsBadges(?array $data, string $class = 'border text-slate-600'): string
    {
        return implode(array_map(static function ($key, $value) use ($class) {
            return '<span class="px-2 py-1 rounded-full whitespace-nowrap mr-2 '.$class.'">'.ucfirst($key).': '.static::valueToString($value).'</span> ';
        }, array_keys($data), $data));
    }

    /**
     * @param ?array $data
     * @param string $delimiter = ' - '
     *
     * @return string
     */
    public static function arrayAsText(?array $data, string $delimiter = ' - '): string
    {
        return implode($delimiter, array_map(static fn ($key, $value) => ucfirst($key).': '.static::valueToString($value), array_keys($data), $data));
    }

    /**
     * @param mixed $value
     *
     * @return string
     */
    public static function valueToString(mixed $value): string
    {
        if (is_array($value) || is_object($value)) {
            return substr(json_encode($value), 0, 20).'...';
        }

        return strval($value);
    }

    /**
     * @param ?string $date
     * @param ?string $timezone = null
     * @param string $format = 'd/m/Y H:i'
     *
     * @return string
     */
    public static function dateWithTimezone(?string $date, ?string $timezone = null, string $format = 'd/m/Y H:i'): string
    {
        static $timezone_default;

        if (empty($date)) {
            return '';
        }

        if (empty($timezone)) {
            $timezone_default ??= TimezoneModel::query()->whereDefault()->value('zone');
        }

        return helper()->dateUtcToTimezone('Y-m-d H:i:s', $date, $timezone ?: $timezone_default, $format);
    }

    /**
     * @param ?string $date
     * @param string $format = 'd/m/Y H:i'
     *
     * @return string
     */
    public static function dateWithUserTimezone(?string $date, string $format = 'd/m/Y H:i'): string
    {
        return static::dateWithTimezone($date, app('user')->timezone->zone, $format);
    }
}
