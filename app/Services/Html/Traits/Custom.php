<?php declare(strict_types=1);

namespace App\Services\Html\Traits;

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
}
