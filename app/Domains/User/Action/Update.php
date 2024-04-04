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

        $this->row->api_key = $this->data['api_key'];
        $this->row->api_key_prefix = $this->data['api_key_prefix'];
        $this->row->api_key_enabled = $this->data['api_key_enabled'];

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
