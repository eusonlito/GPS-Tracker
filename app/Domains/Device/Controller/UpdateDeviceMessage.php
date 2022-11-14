<?php declare(strict_types=1);

namespace App\Domains\Device\Controller;

use Illuminate\Http\Response;

class UpdateDeviceMessage extends ControllerAbstract
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

        return $this->page('device.update-device-message', [
            'row' => $this->row,
            'messages' => $this->row->messages()->list()->get(),
        ]);
    }
}
