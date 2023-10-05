<?php declare(strict_types=1);

namespace App\Domains\User\Controller;

use Illuminate\Http\Response;
use App\Domains\UserSession\Model\UserSession as UserSessionModel;
use App\Domains\UserSession\Model\Collection\UserSession as UserSessionCollection;

class UpdateUserSession extends ControllerAbstract
{
    /**
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(int $id): Response
    {
        $this->row($id);

        $this->meta('title', __('user-update-user-session.meta-title', ['title' => $this->row->name]));

        return $this->page('user.update-user-session', [
            'row' => $this->row,
            'sessions' => $this->sessions(),
        ]);
    }

    /**
     * @return \App\Domains\UserSession\Model\Collection\UserSession
     */
    protected function sessions(): UserSessionCollection
    {
        return UserSessionModel::query()
            ->byUser($this->row)
            ->unionUserFailByUser($this->row)
            ->list()
            ->get();
    }
}
