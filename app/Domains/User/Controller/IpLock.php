<?php declare(strict_types=1);

namespace App\Domains\User\Controller;

use Illuminate\Http\Response;
use App\Domains\IpLock\Model\IpLock as IpLockModel;
use App\Domains\IpLock\Model\Collection\IpLock as IpLockCollection;

class IpLock extends ControllerAbstract
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function __invoke(): Response
    {
        $this->meta('title', __('user-ip-lock.meta-title'));

        return $this->page('user.ip-lock', [
            'locks' => $this->locks(),
        ]);
    }

    /**
     * @return \App\Domains\IpLock\Model\Collection\IpLock
     */
    protected function locks(): IpLockCollection
    {
        return IpLockModel::query()
            ->list()
            ->get();
    }
}
