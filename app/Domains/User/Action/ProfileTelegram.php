<?php declare(strict_types=1);

namespace App\Domains\User\Action;

use App\Domains\User\Model\User as Model;

class ProfileTelegram extends ActionAbstract
{
    /**
     * @return \App\Domains\User\Model\User
     */
    public function handle(): Model
    {
        $this->data();
        $this->save();

        return $this->row;
    }

    /**
     * @return void
     */
    protected function data(): void
    {
        $this->dataName();
    }

    /**
     * @return void
     */
    protected function dataName(): void
    {
        $this->data['telegram']['username'] = trim(str_replace('@', '', $this->data['telegram']['username']));
    }

    /**
     * @return void
     */
    protected function save(): void
    {
        $this->row->telegram = $this->data['telegram'] + (array)$this->row->telegram;
        $this->row->save();
    }
}
