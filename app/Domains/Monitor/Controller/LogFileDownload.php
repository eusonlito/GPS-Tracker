<?php declare(strict_types=1);

namespace App\Domains\Monitor\Controller;

use Symfony\Component\HttpFoundation\StreamedResponse;
use App\Domains\Monitor\Controller\Service\LogFileDownload as ControllerService;

class LogFileDownload extends ControllerAbstract
{
    /**
     * @param string $path
     * @param string $file
     *
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function __invoke(string $path, string $file): StreamedResponse
    {
        return ControllerService::new($this->request, $this->auth, $path, $file)->data();
    }
}
