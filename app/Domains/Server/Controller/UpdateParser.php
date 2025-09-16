<?php declare(strict_types=1);

namespace App\Domains\Server\Controller;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use App\Domains\Server\Controller\Service\UpdateParser as ControllerService;

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

        $this->meta('title', __('server-update-parser.meta-title', ['title' => $this->row->port.' - '.$this->row->protocol]));

        return $this->page('server.update-parser', $this->data());
    }

    /**
     * @return array
     */
    protected function data(): array
    {
        return ControllerService::new($this->request, $this->auth, $this->row, $this->actionPost('parse'))->data();
    }

    /**
     * @return array
     */
    protected function parse(): array
    {
        return $this->action()->parse();
    }
}
