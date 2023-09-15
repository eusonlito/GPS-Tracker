<?php declare(strict_types=1);

namespace App\Domains\File\Controller;

use Symfony\Component\HttpFoundation\BinaryFileResponse;

class View extends ControllerAbstract
{
    /**
     * @param int $id
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function __invoke(int $id): BinaryFileResponse
    {
        $this->row($id);

        if ($this->row->fileExists() === false) {
            abort(404);
        }

        return response()->file($this->row->filePath());
    }
}
