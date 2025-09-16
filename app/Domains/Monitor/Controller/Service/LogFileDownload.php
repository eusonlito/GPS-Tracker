<?php declare(strict_types=1);

namespace App\Domains\Monitor\Controller\Service;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class LogFileDownload extends LogAbstract
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
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function data(): StreamedResponse
    {
        return response()->stream($this->readfile(...), 200, $this->headers());
    }

    /**
     * @return void
     */
    protected function readfile(): void
    {
        readfile($this->fullpath().'/'.$this->file);
    }

    /**
     * @return array
     */
    protected function headers(): array
    {
        return [
            'Content-Type' => 'application/octet-stream',
            'Content-Disposition' => 'attachment; filename="'.$this->file.'"',
        ];
    }
}
