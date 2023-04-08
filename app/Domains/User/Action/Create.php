<?php declare(strict_types=1);

namespace App\Domains\User\Action;

use Illuminate\Support\Facades\Hash;
use App\Domains\Language\Model\Language as LanguageModel;
use App\Domains\User\Model\User as Model;
use App\Exceptions\ValidatorException;

class Create extends ActionAbstract
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
        $this->dataAdmin();
        $this->dataEnabled();
        $this->dataPassword();
        $this->dataPreferences();
        $this->dataLanguageId();
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
    protected function dataAdmin(): void
    {
        $this->data['admin'] ??= 1;
    }

    /**
     * @return void
     */
    protected function dataEnabled(): void
    {
        $this->data['enabled'] ??= 1;
    }

    /**
     * @return void
     */
    protected function dataPassword(): void
    {
        $this->data['password'] = Hash::make($this->data['password']);
    }

    /**
     * @return void
     */
    protected function dataPreferences(): void
    {
        $this->data['preferences'] = [];
    }

    /**
     * @return void
     */
    protected function dataLanguageId(): void
    {
        $this->data['language_id'] = LanguageModel::query()
            ->selectOnly('id')
            ->whenIdOrDefault((int)$this->data['language_id'])
            ->firstOrFail()
            ->id;
    }

    /**
     * @return void
     */
    protected function check(): void
    {
        $this->checkEmail();
    }

    /**
     * @return void
     */
    protected function checkEmail(): void
    {
        if (Model::query()->byEmail($this->data['email'])->count()) {
            throw new ValidatorException(__('user-create.error.email-exists'));
        }
    }

    /**
     * @return void
     */
    protected function save(): void
    {
        $this->row = Model::query()->create([
            'name' => $this->data['name'],
            'email' => $this->data['email'],
            'password' => $this->data['password'],
            'preferences' => $this->data['preferences'],
            'admin' => $this->data['admin'],
            'enabled' => $this->data['enabled'],
            'language_id' => $this->data['language_id'],
        ]);
    }
}
