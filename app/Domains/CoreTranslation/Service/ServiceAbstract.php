<?php declare(strict_types=1);

namespace App\Domains\CoreTranslation\Service;

use Generator;
use Illuminate\Support\Arr;
use App\Services\Filesystem\Directory as DirectoryService;
use App\Services\Filesystem\File as FileService;

abstract class ServiceAbstract
{
    /**
     * @var array
     */
    protected array $folders = ['app', 'resources/views'];

    /**
     * @return self
     */
    public static function new(): self
    {
        return new static(...func_get_args());
    }

    /**
     * @param array $folders = []
     *
     * @return self
     */
    public function __construct(array $folders = [])
    {
        if ($folders) {
            $this->folders = $folders;
        }
    }

    /**
     * @return array
     */
    public function scan(): array
    {
        $found = [];

        foreach ($this->folders as $folder) {
            foreach ($this->read(base_path($folder)) as $file) {
                if ($matches = $this->file($file)) {
                    $found[$this->fileRelative($file)] = $matches;
                }
            }
        }

        return $found;
    }

    /**
     * @param string $dir
     *
     * @return \Generator
     */
    protected function read(string $dir): Generator
    {
        return DirectoryService::files($dir, $this->readInclude(), $this->readExclude());
    }

    /**
     * @return string
     */
    protected function readInclude(): string
    {
        return '/\.php$/';
    }

    /**
     * @return string
     */
    protected function readExclude(): string
    {
        return '/\/node_modules\//';
    }

    /**
     * @param array $array
     *
     * @return array
     */
    protected function undot(array $array): array
    {
        ksort($array);

        $values = [];

        foreach ($array as $key => $value) {
            Arr::set($values, $key, $value);
        }

        return $values;
    }

    /**
     * @param string $file
     * @param array $values
     *
     * @return void
     */
    protected function writeFile(string $file, array $values): void
    {
        FileService::write($file, $values, true);
    }

    /**
     * @param string $file
     *
     * @return string
     */
    protected function fileRelative(string $file): string
    {
        return str_replace(base_path(), '', $file);
    }
}
