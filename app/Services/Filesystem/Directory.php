<?php declare(strict_types=1);

namespace App\Services\Filesystem;

use Generator;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileInfo;

class Directory
{
    /**
     * @param string $dir
     * @param array $extensions = []
     * @param array $exclude = []
     *
     * @return \Generator
     */
    public static function files(string $dir, array $extensions = [], array $exclude = []): Generator
    {
        if (is_dir($dir) === false) {
            return [];
        }

        $extensions = array_map('strtolower', $extensions);

        foreach (static::directoryIterator($dir) as $file) {
            if (static::filesValid($file, $extensions, $exclude)) {
                yield $file->getPathName();
            }
        }
    }

    /**
     * @param string $dir
     *
     * @return \RecursiveIteratorIterator
     */
    protected static function directoryIterator(string $dir): RecursiveIteratorIterator
    {
        return new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir), RecursiveIteratorIterator::SELF_FIRST);
    }

    /**
     * @param \SplFileInfo $file
     * @param array $extensions
     * @param array $exclude
     *
     * @return bool
     */
    protected static function filesValid(SplFileInfo $file, array $extensions, array $exclude): bool
    {
        return $file->isFile()
            && (empty($extensions) || in_array(strtolower($file->getExtension()), $extensions))
            && (empty($exclude) || ($file->getPathName() === str_replace($exclude, '', $file->getPathName())));
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
