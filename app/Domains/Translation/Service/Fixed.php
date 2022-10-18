<?php declare(strict_types=1);

namespace App\Domains\Translation\Service;

class Fixed extends ServiceAbstract
{
    /**
     * @var array
     */
    protected array $pathsExclude;

    /**
     * @param array $paths_exclude = []
     *
     * @return self
     */
    public function __construct(array $paths_exclude = [])
    {
        $this->pathsExclude = array_map(static fn ($value) => realpath(base_path(trim($value, '/'))), $paths_exclude);
    }

    /**
     * @param string $file
     *
     * @return ?array
     */
    protected function file(string $file): ?array
    {
        $file = realpath($file);

        if ($this->fileExcluded($file)) {
            return null;
        }

        $contents = file($file);
        $matches = preg_grep('/[^-]>\w[\w\s]+</', $contents) + preg_grep('/(title|placeholder)="[\w\s]+"/', $contents);

        return $matches ? [$this->fileRelative($file) => $matches] : null;
    }

    /**
     * @param string $file
     *
     * @return bool
     */
    protected function fileExcluded(string $file): bool
    {
        foreach ($this->pathsExclude as $path) {
            if (str_starts_with($file, $path)) {
                return true;
            }
        }

        return false;
    }
}
