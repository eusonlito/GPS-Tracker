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
        $this->dataUsername();
        $this->dataChatId();
    }

    /**
     * @return void
     */
    protected function dataUsername(): void
    {
        $this->data['telegram']['username'] = trim(str_replace('@', '', $this->data['telegram']['username']));
    }

    /**
     * @return void
     */
    protected function dataChatId(): void
    {
        if (empty($this->data['telegram']['username'])) {
            $this->data['telegram']['chat_id'] = null;
        }
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
