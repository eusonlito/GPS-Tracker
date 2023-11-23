<?php declare(strict_types=1);

namespace App\Services\Html;

use App\Domains\Timezone\Model\Timezone as TimezoneModel;
use App\Services\Html\Traits\Custom as CustomTrait;

class Html
{
    use CustomTrait;

    /**
     * @param ?string $path
     *
     * @return string
     */
    public static function asset(?string $path): string
    {
        static $cache = [];

        if (empty($path)) {
            return '';
        }

        if (str_starts_with($path, 'data:')) {
            return $path;
        }

        if (isset($cache[$path])) {
            return $cache[$path];
        }

        if (is_file($file = public_path($path))) {
            $path .= '?v'.filemtime($file);
        }

        return $cache[$path] = asset($path);
    }

    /**
     * @param string $path
     *
     * @return string
     */
    public static function assetManifest(string $path): string
    {
        if (config('app.debug')) {
            return $path;
        }

        $manifest = public_path('build/rev-manifest.json');

        if (is_file($manifest) === false) {
            return asset($path);
        }

        return json_decode(file_get_contents($manifest), true)[$path] ?? asset($path);
    }

    /**
     * @param ?string $path
     * @param bool $cache = true
     * @param bool $image = false
     *
     * @return string
     */
    public static function inline(?string $path, bool $cache = true, bool $image = false): string
    {
        static $cache = [];

        if (empty($path)) {
            return '';
        }

        if ($cache && isset($cache[$path])) {
            return $cache[$path];
        }

        $file = public_path($path);
        $contents = is_file($file) ? file_get_contents($file) : '';

        if ($image) {
            $contents = 'data:image/'.pathinfo($file, PATHINFO_EXTENSION).';base64,'.base64_encode($contents);
        }

        return $cache ? ($cache[$path] = $contents) : $contents;
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

    /**
     * @param string $text
     * @param int $limit = 140
     * @param string $end = '...'
     *
     * @return string
     */
    public static function cut(string $text, int $limit = 140, string $end = '...'): string
    {
        if (strlen($text) <= (int)$limit) {
            return $text;
        }

        $length = strlen($text);
        $num = 0;
        $tag = 0;

        for ($n = 0; $n < $length; $n++) {
            if ($text[$n] === '<') {
                $tag++;

                continue;
            }

            if ($text[$n] === '>') {
                $tag--;

                continue;
            }

            if ($tag !== 0) {
                continue;
            }

            $num++;

            if ($num < $limit) {
                continue;
            }

            $text = substr($text, 0, $n);

            if ($space = strrpos($text, ' ')) {
                $text = substr($text, 0, $space);
            }

            break;
        }

        if (strlen($text) === $length) {
            return $text;
        }

        $text .= $end;

        if (!preg_match_all('|(<([\w]+)[^>]*>)|', $text, $aBuffer) || empty($aBuffer[1])) {
            return $text;
        }

        preg_match_all('|</([a-zA-Z]+)>|', $text, $aBuffer2);

        if (count($aBuffer[2]) === count($aBuffer2[1])) {
            return $text;
        }

        foreach ($aBuffer[2] as $k => $tag) {
            if (empty($aBuffer2[1][$k]) || ($tag !== $aBuffer2[1][$k])) {
                $text .= '</'.$tag.'>';
            }
        }

        return $text;
    }
}
