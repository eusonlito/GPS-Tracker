<?php declare(strict_types=1);

namespace App\Domains\Server\Controller;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

class UpdateParser extends ControllerAbstract
{
    /**
     * @param int $id
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function __invoke(int $id): Response|RedirectResponse
    {
        $this->row($id);

        $this->meta('title', $this->row->name);

        return $this->page('server.update-parser', [
            'row' => $this->row,
            'parsed' => $this->actionPost('parse'),
        ]);
    }

    /**
     * @return array
     */
    protected function parse(): array
    {
        return $this->action()->parse();
    }
}
