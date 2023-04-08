<?php declare(strict_types=1);

namespace App\Domains\Profile\Action;

use Illuminate\Support\Facades\Hash;
use App\Domains\Language\Model\Language as LanguageModel;
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
        $this->dataPreferences();
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
        $this->data['language_id'] = LanguageModel::query()->byId($this->data['language_id'])->firstOrFail()->id;
    }

    /**
     * @return void
     */
    protected function dataPreferences(): void
    {
        $this->data['preferences'] += (array)$this->row->preferences;
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
        if (Model::query()->byIdNot($this->row->id)->byEmail($this->data['email'])->count()) {
            throw new ValidatorException(__('profile-update.error.email-exists'));
        }
    }

    /**
     * @return void
     */
    protected function save(): void
    {
        $this->row->name = $this->data['name'];
        $this->row->email = $this->data['email'];
        $this->row->password = $this->data['password'];
        $this->row->language_id = $this->data['language_id'];
        $this->row->preferences = $this->data['preferences'];

        $this->row->save();
    }
}
