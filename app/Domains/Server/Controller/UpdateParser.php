<?php declare(strict_types=1);

namespace App\Domains\Server\Controller;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use App\Services\Protocol\ProtocolFactory;

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

        return $this->page('server.update-parser', [
            'row' => $this->row,
            'protocol' => ProtocolFactory::get($this->row->protocol),
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
