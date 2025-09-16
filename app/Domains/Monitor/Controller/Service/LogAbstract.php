<?php declare(strict_types=1);

namespace App\Domains\Monitor\Controller\Service;

use stdClass;

abstract class LogAbstract extends ControllerAbstract
{
    /**
     * @var string
     */
    protected string $basepath;

    /**
     * @var string
     */
    protected string $fullpath;

    /**
     * @const string
     */
    protected const BASE = 'storage/logs';

    /**
     * @return void
     */
    protected function path(): void
    {
        $this->path = $this->pathValid();
    }

    /**
     * @return string
     */
    protected function pathValid(): string
    {
        $path = base64_decode($this->path);

        if (empty($path)) {
            return '';
        }

        if (preg_match('/^[a-zA-Z0-9_\.\/\-]+$/', $path) === 0) {
            return '';
        }

        if (str_contains($path, '..')) {
            return '';
        }

        $path = preg_replace('/\/+/', '/', trim($path, '/'));

        if (is_dir($this->basepath().'/'.$path) === false) {
            return '';
        }

        return $path;
    }

    /**
     * @return void
     */
    protected function file(): void
    {
        if (empty($file = $this->fileValid())) {
            abort(404);
        }

        $this->file = $file;
    }

    /**
     * @return ?string
     */
    protected function fileValid(): ?string
    {
        $file = base64_decode($this->file);

        if (empty($file)) {
            return null;
        }

        if (preg_match('/\.(csv|json|log|zip)$/i', $file) === 0) {
            return null;
        }

        $fullpath = $this->fullpath().'/'.$file;

        if (is_file($fullpath) === false) {
            return null;
        }

        if (is_readable($fullpath) === false) {
            return null;
        }

        return $file;
    }

    /**
     * @return string
     */
    protected function basepath(): string
    {
        return $this->basepath ??= base_path(static::BASE);
    }

    /**
     * @return string
     */
    protected function fullpath(): string
    {
        return $this->fullpath ??= $this->basepath().'/'.$this->path;
    }

    /**
     * @return array
     */
    protected function breadcrumb(): array
    {
        $breadcrumb = [];
        $acum = [];

        foreach (array_filter(explode('/', $this->path)) as $path) {
            $breadcrumb[] = $this->breadcrumbDir($path, $acum);
        }

        if (isset($this->file)) {
            $breadcrumb[] = $this->breadcrumbFile($acum);
        }

        return $breadcrumb;
    }

    /**
     * @param string $path
     * @param array &$acum
     *
     * @return \stdClass
     */
    protected function breadcrumbDir(string $path, array &$acum): stdClass
    {
        return (object)[
            'name' => $path,
            'route' => route('monitor.log.path', $this->pathUrl(implode('/', ($acum[] = $path) ? $acum : []))),
        ];
    }

    /**
     * @param array $acum
     *
     * @return \stdClass
     */
    protected function breadcrumbFile(array $acum): stdClass
    {
        return (object)[
            'name' => $this->file,
            'route' => route('monitor.log.file', [$this->pathUrl(implode('/', $acum)), base64_encode($this->file)]),
        ];
    }

    /**
     * @param string $path
     *
     * @return string
     */
    protected function pathUrl(string $path): string
    {
        return base64_encode($path ?: '/');
    }
}
