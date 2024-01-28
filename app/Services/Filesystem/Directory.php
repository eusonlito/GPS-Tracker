<?php declare(strict_types=1);

namespace App\Services\Filesystem;

use Generator;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RegexIterator;
use SplFileInfo;

class Directory
{
    /**
     * @param string $dir
     * @param ?string $include = null
     * @param ?string $exclude = null
     *
     * @return \Generator
     */
    public static function files(string $dir, ?string $include = null, ?string $exclude = null): Generator
    {
        if (is_dir($dir) === false) {
            return [];
        }

        foreach (static::directoryIterator($dir, $include) as $file) {
            if (static::filesValid($file, $exclude)) {
                yield $file->getPathName();
            }
        }
    }

    /**
     * @param string $dir
     * @param ?string $include
     *
     * @return \RecursiveIteratorIterator|\RegexIterator
     */
    protected static function directoryIterator(string $dir, ?string $include): RecursiveIteratorIterator|RegexIterator
    {
        $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir), RecursiveIteratorIterator::SELF_FIRST);

        if ($include) {
            $iterator = new RegexIterator($iterator, $include);
        }

        return $iterator;
    }

    /**
     * @param \SplFileInfo $file
     * @param ?string $exclude
     *
     * @return bool
     */
    protected static function filesValid(SplFileInfo $file, ?string $exclude): bool
    {
        if ($file->isDir()) {
            return false;
        }

        return empty($exclude)
            || (preg_match($exclude, $file->getPathName()) === 0);
    }

    /**
     * @param string $dir
     * @param bool $file = false
     *
     * @return string
     */
    public static function create(string $dir, bool $file = false): string
    {
        return helper()->mkdir($dir, $file);
    }
}
