<?php declare(strict_types=1);

namespace App\Domains\Device\Controller;

use Illuminate\Http\Response;
use Illuminate\Support\Collection;

class UpdateAlarm extends ControllerAbstract
{
    /**
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(int $id): Response
    {
        $this->row($id);

        $this->meta('title', $this->row->name);

        return $this->page('device.update-alarm', [
            'row' => $this->row,
            'alarms' => $this->alarms(),
        ]);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    protected function alarms(): Collection
    {
        return $this->row->alarms()
            ->list()
            ->get();
    }
}
