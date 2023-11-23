<?php declare(strict_types=1);

namespace App\Domains\User\Action;

use Illuminate\Support\Facades\Hash;
use App\Domains\Language\Model\Language as LanguageModel;
use App\Domains\Timezone\Model\Timezone as TimezoneModel;
use App\Domains\User\Model\User as Model;
use App\Exceptions\ValidatorException;

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
    protected function dataLanguageId(): void
    {
        if ($this->data['language_id']) {
            $this->data['language_id'] = $this->dataLanguageIdQuery();
        } else {
            $this->data['language_id'] = $this->row->language_id;
        }
    }

    /**
     * @return int
     */
    protected function dataLanguageIdQuery(): int
    {
        return LanguageModel::query()
            ->selectOnly('id')
            ->byId($this->data['language_id'])
            ->firstOrFail()
            ->id;
    }

    /**
     * @return void
     */
    protected function dataTimezoneId(): void
    {
        if ($this->data['timezone_id']) {
            $this->data['timezone_id'] = $this->dataTimezoneIdQuery();
        } else {
            $this->data['timezone_id'] = $this->row->timezone_id;
        }
    }

    /**
     * @return int
     */
    protected function dataTimezoneIdQuery(): int
    {
        return TimezoneModel::query()
            ->selectOnly('id')
            ->byId($this->data['timezone_id'])
            ->firstOrFail()
            ->id;
    }

    /**
     * @return void
     */
    protected function check(): void
    {
        $this->checkEmail();
        $this->checkStatus();
    }

    /**
     * @return void
     */
    protected function checkEmail(): void
    {
        if (Model::query()->byIdNot($this->row->id)->byEmail($this->data['email'])->count()) {
            throw new ValidatorException(__('user-update.error.email-exists'));
        }
    }

    /**
     * @return void
     */
    protected function checkStatus(): void
    {
        if ($this->row->id !== $this->auth->id) {
            return;
        }

        if (empty($this->data['admin'])) {
            throw new ValidatorException(__('user-update.error.admin-own'));
        }

        if (empty($this->data['enabled'])) {
            throw new ValidatorException(__('user-update.error.enabled-own'));
        }
    }

    /**
     * @return void
     */
    protected function save(): void
    {
        $this->row->name = $this->data['name'];
        $this->row->email = $this->data['email'];
        $this->row->admin = $this->data['admin'];
        $this->row->manager = $this->data['manager'];
        $this->row->enabled = $this->data['enabled'];
        $this->row->password = $this->data['password'];
        $this->row->language_id = $this->data['language_id'];
        $this->row->timezone_id = $this->data['timezone_id'];

        $this->row->save();
    }
}
