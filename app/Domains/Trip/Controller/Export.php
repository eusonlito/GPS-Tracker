<?php declare(strict_types=1);

namespace App\Domains\Trip\Controller;

use Symfony\Component\HttpFoundation\StreamedResponse;

class Export extends ControllerAbstract
{
    /**
     * @param int $id
     *
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function __invoke(int $id): StreamedResponse
    {
        $this->row($id);

        return $this->action()->export();
    }
}
