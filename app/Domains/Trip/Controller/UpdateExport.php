<?php declare(strict_types=1);

namespace App\Domains\Trip\Controller;

use Symfony\Component\HttpFoundation\StreamedResponse;

class UpdateExport extends ControllerAbstract
{
    /**
     * @param int $id
     *
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function __invoke(int $id): StreamedResponse
    {
        $this->row($id);

        return $this->action()->updateExport();
    }
}
