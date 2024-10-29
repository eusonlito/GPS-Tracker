<?php declare(strict_types=1);

namespace App\Domains\Monitor\Service\Controller;

use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Authenticatable;
use App\Services\Compress\Zip\Contents as ZipContents;

class LogFile extends LogAbstract
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Contracts\Auth\Authenticatable $auth
     * @param string $path
     * @param string $file
     *
     * @return self
     */
    public function __construct(
        protected Request $request,
        protected Authenticatable $auth,
        protected string $path,
        protected string $file,
    ) {
        $this->path();
        $this->file();
    }

    /**
     * @return array
     */
    public function data(): array
    {
        return [
            'path' => $this->path,
            'file' => $this->file,
            'breadcrumb' => $this->breadcrumb(),
            'contents' => $this->contents(),
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
        $file = $this->fullpath().'/'.$this->file;

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