<?php declare(strict_types=1);

namespace App\Domains\User\Controller;

use Illuminate\Http\Response;
use App\Domains\UserSession\Model\UserSession as UserSessionModel;
use App\Domains\UserSession\Model\Collection\UserSession as UserSessionCollection;

class UserSession extends ControllerAbstract
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function __invoke(): Response
    {
        $this->meta('title', __('user-user-session.meta-title'));

        return $this->page('user.user-session', [
            'sessions' => $this->sessions(),
        ]);
    }

    /**
     * @return \App\Domains\UserSession\Model\Collection\UserSession
     */
    protected function sessions(): UserSessionCollection
    {
        return UserSessionModel::query()
            ->withUser()
            ->list()
            ->get();
    }
}
