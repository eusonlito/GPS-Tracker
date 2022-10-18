<?php declare(strict_types=1);

namespace App\Services\Filesystem;

class File
{
    /**
     * @param string $file
     * @param string|array $contents
     * @param bool $array = false
     *
     * @return void
     */
    public static function write(string $file, $contents, bool $array = false): void
    {
        Directory::create($file, true);

        file_put_contents($file, $array ? static::array($contents) : $contents, LOCK_EX);
    }

    /**
     * @param array $array
     *
     * @return string
     */
    protected static function array(array $array): string
    {
        $array = static::ksort($array);

        $export = var_export($array, true);
        $export = preg_replace('/^([ ]*)(.*)/m', '$1$1$2', $export);

        $export = preg_split('/\r\n|\n|\r/', $export);
        $export = preg_replace(['/\s*array\s\($/', '/\)(,)?$/', '/\s=>\s$/'], [null, ']$1', ' => ['], $export);

        $export = implode(PHP_EOL, array_filter(['['] + (array)$export));
        $export = preg_replace('(\d+\s=>\s)', '', $export);

        return '<?php return '.trim($export).';'."\n";
    }

    /**
     * @param array $array
     *
     * @return array
     */
    protected static function ksort(array $array): array
    {
        ksort($array);

        return array_map(static fn ($value) => is_array($value) ? static::ksort($value) : $value, $array);
    }
}
