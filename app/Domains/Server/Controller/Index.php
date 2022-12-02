<?php declare(strict_types=1);

namespace App\Domains\Server\Controller;

use Illuminate\Http\Response;
use App\Domains\Server\Model\Server as Model;

class Index extends ControllerAbstract
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function __invoke(): Response
    {
        $this->meta('title', __('server-index.meta-title'));

        return $this->page('server.index', [
            'list' => Model::query()->list()->get(),
        ]);
    }
}
