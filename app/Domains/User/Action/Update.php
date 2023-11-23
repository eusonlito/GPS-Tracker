<?php declare(strict_types=1);

namespace App\Domains\User\Action;

class Update extends CreateUpdateAbstract
{
    /**
     * @return void
     */
    protected function save(): void
    {
        $this->row->name = $this->data['name'];
        $this->row->email = $this->data['email'];
        $this->row->password = $this->data['password'];
        $this->row->preferences = $this->data['preferences'];
        $this->row->admin = $this->data['admin'];
        $this->row->admin_mode = $this->data['admin'];
        $this->row->manager = $this->data['manager'];
        $this->row->manager_mode = $this->data['manager'];
        $this->row->enabled = $this->data['enabled'];
        $this->row->language_id = $this->data['language_id'];
        $this->row->timezone_id = $this->data['timezone_id'];

        $this->row->save();
    }
}
