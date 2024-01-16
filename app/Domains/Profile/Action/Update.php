<?php declare(strict_types=1);

namespace App\Domains\Profile\Action;

use Illuminate\Support\Facades\Hash;
use App\Domains\Language\Model\Language as LanguageModel;
use App\Domains\Timezone\Model\Timezone as TimezoneModel;
use App\Domains\User\Model\User as Model;

class Update extends ActionAbstract
{
    /**
     * @return \App\Domains\User\Model\User
     */
    public function handle(): Model
    {
        $this->data();
        $this->check();
        $this->save();

        return $this->row;
    }

    /**
     * @return void
     */
    protected function data(): void
    {
        $this->dataName();
        $this->dataEmail();
        $this->dataPassword();
        $this->dataPreferences();
        $this->dataAdminMode();
        $this->dataManagerMode();
    }

    /**
     * @return void
     */
    protected function dataName(): void
    {
        $this->data['name'] = trim($this->data['name']);
    }

    /**
     * @return void
     */
    protected function dataEmail(): void
    {
        $this->data['email'] = strtolower($this->data['email']);
    }

    /**
     * @return void
     */
    protected function dataPassword(): void
    {
        if ($this->data['password']) {
            $this->data['password'] = Hash::make($this->data['password']);
        } else {
            $this->data['password'] = $this->row->password;
        }
    }

    /**
     * @return void
     */
    protected function dataPreferences(): void
    {
        $this->data['preferences'] = array_replace_recursive($this->row->preferences, $this->data['preferences']);
    }

    /**
     * @return void
     */
    protected function dataAdminMode(): void
    {
        $this->data['admin_mode'] = $this->row->admin && $this->data['admin_mode'];
    }

    /**
     * @return void
     */
    protected function dataManagerMode(): void
    {
        $this->data['manager_mode'] = $this->row->manager && $this->data['manager_mode'];
    }

    /**
     * @return void
     */
    protected function check(): void
    {
        $this->checkEmail();
        $this->checkLanguageId();
        $this->checkTimezoneId();
    }

    /**
     * @return void
     */
    protected function checkEmail(): void
    {
        if ($this->checkEmailExists()) {
            $this->exceptionValidator(__('profile-update.error.email-exists'));
        }
    }

    /**
     * @return bool
     */
    protected function checkEmailExists(): bool
    {
        return Model::query()
            ->byIdNot($this->row->id)
            ->byEmail($this->data['email'])
            ->exists();
    }

    /**
     * @return void
     */
    protected function checkLanguageId(): void
    {
        if ($this->checkLanguageIdExists() === false) {
            $this->exceptionValidator(__('profile-update.error.language-exists'));
        }
    }

    /**
     * @return bool
     */
    protected function checkLanguageIdExists(): bool
    {
        return LanguageModel::query()
            ->byId($this->data['language_id'])
            ->exists();
    }

    /**
     * @return void
     */
    protected function checkTimezoneId(): void
    {
        if ($this->checkTimezoneIdExists() === false) {
            $this->exceptionValidator(__('profile-update.error.timezone-exists'));
        }
    }

    /**
     * @return bool
     */
    protected function checkTimezoneIdExists(): bool
    {
        return TimezoneModel::query()
            ->byId($this->data['timezone_id'])
            ->exists();
    }

    /**
     * @return void
     */
    protected function save(): void
    {
        $this->row->name = $this->data['name'];
        $this->row->email = $this->data['email'];
        $this->row->password = $this->data['password'];
        $this->row->preferences = $this->data['preferences'];
        $this->row->admin_mode = $this->data['admin_mode'];
        $this->row->manager_mode = $this->data['manager_mode'];
        $this->row->language_id = $this->data['language_id'];
        $this->row->timezone_id = $this->data['timezone_id'];

        $this->row->save();
    }
}
