<?php declare(strict_types=1);

namespace App\Domains\Monitor\Service\Controller;

use DirectoryIterator;
use stdClass;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Authenticatable;

class Log extends LogAbstract
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Contracts\Auth\Authenticatable $auth
     *
     * @return self
     */
    public function __construct(
        protected Request $request,
        protected Authenticatable $auth,
        protected string $path
    ) {
        $this->path();
    }

    /**
     * @return array
     */
    public function data(): array
    {
        return [
            'path' => $this->path,
            'breadcrumb' => $this->breadcrumb(),
            'list' => $this->list(),
        ];
    }

    /**
     * @return bool
     */
    protected function isFile(): bool
    {
        return false;
    }

    /**
     * @return array
     */
    protected function list(): array
    {
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

        return in_array($fileInfo->getExtension(), ['csv', 'json', 'log', 'zip']);
    }

    /**
     * @param \DirectoryIterator $fileInfo
     *
     * @return \stdClass
     */
    protected function listContent(DirectoryIterator $fileInfo): stdClass
    {
        return (object)[
            'name' => $fileInfo->getBasename(),
            'size' => $fileInfo->getSize(),
            'type' => $fileInfo->isDir() ? 'dir' : 'file',
            'updated_at' => date('Y-m-d H:i:s', $fileInfo->getMTime()),
            'route' => $this->listContentRoute($fileInfo),
            'route_download' => $this->listContentRouteDownload($fileInfo),
        ];
    }

    /**
     * @param \DirectoryIterator $fileInfo
     *
     * @return string
     */
    protected function listContentRoute(DirectoryIterator $fileInfo): string
    {
        return $fileInfo->isDir()
            ? $this->listContentRouteDir($fileInfo)
            : $this->listContentRouteFile($fileInfo);
    }

    /**
     * @param \DirectoryIterator $fileInfo
     *
     * @return string
     */
    protected function listContentRouteDir(DirectoryIterator $fileInfo): string
    {
        return route('monitor.log.path', $this->pathUrl($fileInfo->getPathName()));
    }

    /**
     * @param \DirectoryIterator $fileInfo
     *
     * @return string
     */
    protected function listContentRouteFile(DirectoryIterator $fileInfo): string
    {
        return route('monitor.log.file', [$this->pathUrl($fileInfo->getPath()), base64_encode($fileInfo->getFilename())]);
    }

    /**
     * @param \DirectoryIterator $fileInfo
     *
     * @return ?string
     */
    protected function listContentRouteDownload(DirectoryIterator $fileInfo): ?string
    {
        if ($fileInfo->isDir()) {
            return null;
        }

        return route('monitor.log.file.download', [$this->pathUrl($fileInfo->getPath()), base64_encode($fileInfo->getFilename())]);
    }

    /**
     * @param string $path
     *
     * @return string
     */
    protected function pathUrl(string $path): string
    {
        return base64_encode(str_replace($this->basepath(), '', $path) ?: '/');
    }
}
