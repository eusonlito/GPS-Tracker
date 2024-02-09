<?php declare(strict_types=1);

namespace App\Domains\Monitor\Service\Controller;

use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Authenticatable;
use App\Domains\Monitor\Service\System\CpuMemory;
use App\Domains\Monitor\Service\System\Disk;

class Index extends ControllerAbstract
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Contracts\Auth\Authenticatable $auth
     *
     * @return self
     */
    public function __construct(protected Request $request, protected Authenticatable $auth)
    {
    }

    /**
     * @return array
     */
    public function data(): array
    {
        return $this->cpuMemory() + $this->disk();
    }

    /**
     * @return array
     */
    protected function cpuMemory(): array
    {
        return CpuMemory::new()->get();
    }

    /**
     * @return array
     */
    protected function disk(): array
    {
        return Disk::new()->get();
    }
}
