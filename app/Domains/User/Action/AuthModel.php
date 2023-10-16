<?php declare(strict_types=1);

namespace App\Domains\User\Action;

use Illuminate\Support\Facades\Auth;
use App\Domains\User\Model\User as Model;

class AuthModel extends ActionAbstract
{
    /**
     * @return \App\Domains\User\Model\User
     */
    public function handle(): Model
    {
        $this->login();
        $this->auth();
        $this->userSession();

        return $this->row;
    }

    /**
     * @return void
     */
    protected function login(): void
    {
        Auth::login($this->row, true);
    }

    /**
     * @return void
     */
    protected function auth(): void
    {
        $this->row = $this->auth = Auth::user();
    }

    /**
     * @return void
     */
    protected function userSession(): void
    {
        $this->factory('UserSession')->action($this->saveUserSessionData())->create();
    }

    /**
     * @return array
     */
    protected function saveUserSessionData(): array
    {
        return [
            'auth' => $this->data['email'],
            'ip' => $this->request->ip(),
            'user_id' => $this->row->id,
        ];
    }
}
