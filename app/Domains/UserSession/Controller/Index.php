<?php declare(strict_types=1);

namespace App\Domains\UserSession\Controller;

use Illuminate\Http\Response;
use App\Domains\UserSession\Model\UserSession as Model;
use App\Domains\UserSession\Model\Collection\UserSession as Collection;

class Index extends ControllerAbstract
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function __invoke(): Response
    {
        $this->meta('title', __('user-session-index.meta-title'));

        return $this->page('user-session.index', [
            'list' => $this->list(),
        ]);
    }

    /**
     * @return \App\Domains\UserSession\Model\Collection\UserSession
     */
    protected function list(): Collection
    {
        return Model::query()
            ->unionUserFail()
            ->withUser()
            ->list()
            ->get();
    }
}
