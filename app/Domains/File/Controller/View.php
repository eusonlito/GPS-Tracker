<?php declare(strict_types=1);

namespace App\Domains\File\Controller;

use Symfony\Component\HttpFoundation\StreamedResponse;

class View extends ControllerAbstract
{
    /**
     * @param int $id
     *
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function __invoke(int $id): StreamedResponse
    {
        $this->row($id);

        if ($this->row->fileExists() === false) {
            abort(404);
        }

        return response()->streamDownload(function () {
            echo $this->row->fileContentsGet();
        }, $this->row->name);
    }
}
