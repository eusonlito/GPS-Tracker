<?php declare(strict_types=1);

namespace App\Domains\User\Action;

use Illuminate\Support\Facades\Hash;
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
        if (Model::byIdNot($this->row->id)->byEmail($this->data['email'])->count()) {
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
        $this->row->enabled = $this->data['enabled'];
        $this->row->password = $this->data['password'];

        $this->row->save();
    }
}
