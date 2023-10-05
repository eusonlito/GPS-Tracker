<?php declare(strict_types=1);

namespace App\Domains\Profile\Controller;

use Illuminate\Http\Response;
use App\Domains\UserSession\Model\UserSession as UserSessionModel;
use App\Domains\UserSession\Model\Collection\UserSession as UserSessionCollection;

class UpdateUserSession extends ControllerAbstract
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function __invoke(): Response
    {
        $this->load();

        $this->meta('title', __('profile-update-user-session.meta-title'));

        return $this->page('profile.update-user-session', [
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
