<?php declare(strict_types=1);

namespace App\Domains\Trip\Action;

use Throwable;
use Symfony\Component\HttpFoundation\StreamedResponse;
use App\Services\Gpx\Write as GpxService;

class UpdateExport extends ActionAbstract
{
    /**
     * @return ?\Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function handle(): ?StreamedResponse
    {
        try {
            return $this->response();
        } catch (Throwable $e) {
            return $this->error($e);
        }
    }

    /**
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    protected function response(): StreamedResponse
    {
        return response()->stream($this->readfile(...), 200, $this->headers());
    }

    /**
     * @return void
     */
    protected function readfile(): void
    {
        echo GpxService::new($this->row)->generate()->toXml();
    }

    /**
     * @return array
     */
    protected function headers(): array
    {
        return [
            'Content-Type' => 'application/gpx+xml',
            'Content-Disposition' => 'attachment; filename="'.$this->row->name.'.gpx"',
        ];
    }

    /**
     * @param \Throwable $e
     *
     * @return void
     */
    protected function error(Throwable $e): void
    {
        report($e);

        $this->exceptionNotFound();
    }
}
