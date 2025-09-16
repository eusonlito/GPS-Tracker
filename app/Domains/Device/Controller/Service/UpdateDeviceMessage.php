<?php declare(strict_types=1);

namespace App\Domains\Device\Controller\Service;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use App\Domains\Device\Model\Device as Model;
use App\Domains\DeviceMessage\Model\Collection\DeviceMessage as DeviceMessageCollection;
use App\Domains\DeviceMessage\Model\DeviceMessage as DeviceMessageModel;

class UpdateDeviceMessage extends ControllerAbstract
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Contracts\Auth\Authenticatable $auth
     * @param \App\Domains\Device\Model\Device $row
     *
     * @return self
     */
    public function __construct(protected Request $request, protected Authenticatable $auth, protected Model $row)
    {
    }

    /**
     * @return array
     */
    public function data(): array
    {
        return $this->dataCore() + [
            'row' => $this->row,
            'messages' => $this->messages(),
        ];
    }

    /**
     * @return \App\Domains\DeviceMessage\Model\Collection\DeviceMessage
     */
    protected function messages(): DeviceMessageCollection
    {
        return DeviceMessageModel::query()
            ->byDeviceId($this->row->id)
            ->list()
            ->get();
    }
}
