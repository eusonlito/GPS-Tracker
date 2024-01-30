<?php declare(strict_types=1);

namespace App\Domains\User\Action;

use Illuminate\Support\Facades\Hash;
use App\Domains\Language\Model\Language as LanguageModel;
use App\Domains\Timezone\Model\Timezone as TimezoneModel;
use App\Domains\User\Model\User as Model;

abstract class CreateUpdateAbstract extends ActionAbstract
{
    /**
     * @return void
     */
    abstract protected function save(): void;

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
        $this->dataLanguageId();
        $this->dataTimezoneId();
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
        $this->data['preferences'] = array_replace_recursive(
            $this->row->preferences ?? [],
            $this->data['preferences']
        );
    }

    /**
     * @return void
     */
    protected function dataLanguageId(): void
    {
        if ($this->data['language_id']) {
            return;
        }

        $this->data['language_id'] = $this->row->language_id ?? $this->dataLanguageIdDefault();
    }

    /**
     * @return int
     */
    protected function dataLanguageIdDefault(): int
    {
        return LanguageModel::query()
            ->whereDefault()
            ->value('id');
    }

    /**
     * @return void
     */
    protected function dataTimezoneId(): void
    {
        if ($this->data['timezone_id']) {
            return;
        }

        $this->data['timezone_id'] = $this->row->timezone_id ?? $this->dataTimezoneIdDefault();
    }

    /**
     * @return int
     */
    protected function dataTimezoneIdDefault(): int
    {
        return TimezoneModel::query()
            ->whereDefault()
            ->value('id');
    }

    /**
     * @return void
     */
    protected function check(): void
    {
        $this->checkEmail();
        $this->checkStatus();
        $this->checkLanguageId();
        $this->checkTimezoneId();
    }

    /**
     * @return void
     */
    protected function checkEmail(): void
    {
        if ($this->checkEmailExists()) {
            $this->exceptionValidator(__('user-create.error.email-exists'));
        }
    }

    /**
     * @return bool
     */
    protected function checkEmailExists(): bool
    {
        return Model::query()
            ->byIdNot($this->row->id ?? 0)
            ->byEmail($this->data['email'])
            ->exists();
    }

    /**
     * @return void
     */
    protected function checkStatus(): void
    {
        if (empty($this->row->id) || ($this->row->id !== $this->auth?->id)) {
            return;
        }

        if (empty($this->data['admin'])) {
            $this->exceptionValidator(__('user-create.error.admin-own'));
        }

        if (empty($this->data['enabled'])) {
            $this->exceptionValidator(__('user-create.error.enabled-own'));
        }
    }

    /**
     * @return void
     */
    protected function checkLanguageId(): void
    {
        if ($this->checkLanguageIdExists() === false) {
            $this->exceptionValidator(__('user-create.error.language-exists'));
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
            $this->exceptionValidator(__('user-create.error.timezone-exists'));
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
}
