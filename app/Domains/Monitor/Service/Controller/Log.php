<?php declare(strict_types=1);

namespace App\Domains\Monitor\Service\Controller;

use DirectoryIterator;
use stdClass;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Authenticatable;
use App\Services\Compress\Zip\Contents as ZipContents;

class Log extends ControllerAbstract
{
    /**
     * @var string
     */
    protected string $path;

    /**
     * @var string
     */
    protected string $basepath;

    /**
     * @var string
     */
    protected string $fullpath;

    /**
     * @var bool
     */
    protected bool $isFile;

    /**
     * @const string
     */
    protected const BASE = 'storage/logs';

    /**
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Contracts\Auth\Authenticatable $auth
     *
     * @return self
     */
    public function __construct(protected Request $request, protected Authenticatable $auth)
    {
    }

    /**
     * @return array
     */
    public function handle(): array
    {
        return [$this->view(), $this->data()];
    }

    /**
     * @return string
     */
    public function view(): string
    {
        return $this->isFile() ? 'monitor.log-detail' : 'monitor.log';
    }

    /**
     * @return array
     */
    public function data(): array
    {
        return [
            'is_file' => $this->isFile(),
            'path' => $this->path(),
            'breadcrumb' => $this->breadcrumb(),
            'list' => $this->list(),
            'contents' => $this->contents(),
        ];
    }

    /**
     * @return string
     */
    protected function path(): string
    {
        if (isset($this->path)) {
            return $this->path;
        }

        if (empty($path = $this->request->input('path'))) {
            return $this->path = '';
        }

        $path = base64_decode($path);

        if (preg_match('/^[a-z0-9_\.\/\-]+$/', $path) === 0) {
            return $this->path = '';
        }

        if (str_contains($path, '..')) {
            return $this->path = '';
        }

        $path = preg_replace('/\/+/', '/', trim($path, '/'));

        if (file_exists($this->basepath().'/'.$path) === false) {
            return $this->path = '';
        }

        return $this->path = $path;
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
        return $this->fullpath ??= $this->basepath().'/'.$this->path();
    }

    /**
     * @return bool
     */
    protected function isFile(): bool
    {
        return $this->isFile ??= is_file($this->fullpath());
    }

    /**
     * @return array
     */
    protected function breadcrumb(): array
    {
        $breadcrumb = [];
        $acum = [];

        foreach (explode('/', $this->path()) as $path) {
            $breadcrumb[] = (object)[
                'name' => $path,
                'hash' => base64_encode(implode('/', ($acum[] = $path) ? $acum : [])),
            ];
        }

        return $breadcrumb;
    }

    /**
     * @return array
     */
    protected function list(): array
    {
        if ($this->isFile()) {
            return [];
        }

        $list = [];

        foreach (new DirectoryIterator($this->fullpath()) as $fileInfo) {
            if ($this->listContentIsValid($fileInfo)) {
                $list[] = $this->listContent($fileInfo);
            }
        }

        usort($list, [$this, 'listSort']);

        return $list;
    }

    /**
     * @param \stdClass $a
     * @param \stdClass $b
     *
     * @return int
     */
    protected function listSort(stdClass $a, stdClass $b): int
    {
        if ($a->type !== $b->type) {
            return $a->type <=> $b->type;
        }

        if ($a->type === 'file') {
            return $b->name <=> $a->name;
        }

        $aIsNumber = preg_match('/^[0-9]/', $a->name);
        $bIsNumber = preg_match('/^[0-9]/', $b->name);

        if ($aIsNumber !== $bIsNumber) {
            return $aIsNumber ? -1 : 1;
        }

        return $aIsNumber ? ($b->name <=> $a->name) : ($a->name <=> $b->name);
    }

    /**
     * @param \DirectoryIterator $fileInfo
     *
     * @return bool
     */
    protected function listContentIsValid(DirectoryIterator $fileInfo): bool
    {
        if ($fileInfo->isDot()) {
            return false;
        }

        if ($fileInfo->isDir()) {
            return true;
        }

        return in_array($fileInfo->getExtension(), ['json', 'log', 'zip']);
    }

    /**
     * @param \DirectoryIterator $fileInfo
     *
     * @return \stdClass
     */
    protected function listContent(DirectoryIterator $fileInfo): stdClass
    {
        return (object)[
            'path' => ($path = $fileInfo->getPathname()),
            'location' => ($location = str_replace($this->basepath(), '', $path)),
            'hash' => base64_encode($location),
            'name' => $fileInfo->getBasename(),
            'size' => $fileInfo->getSize(),
            'type' => $fileInfo->isDir() ? 'dir' : 'file',
            'updated_at' => date('Y-m-d H:i:s', $fileInfo->getMTime()),
        ];
    }

    /**
     * @return callable
     */
    protected function contents(): callable
    {
        return fn () => $this->contentsRead();
    }

    /**
     * @return void
     */
    protected function contentsRead(): void
    {
        $file = $this->fullpath();

        if (is_file($file) === false) {
            return;
        }

        if (preg_match('/\.zip$/', $file)) {
            echo ZipContents::new($file)->contents();
        } else {
            readfile($file);
        }
    }
}
