<?php declare(strict_types=1);

namespace App\Domains\Monitor\Service\Controller;

use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Authenticatable;
use App\Domains\Monitor\Service\System\Cpu;
use App\Domains\Monitor\Service\System\Disk;
use App\Domains\Monitor\Service\System\Memory;
use App\Domains\Monitor\Service\System\Summary;

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
        return [
            'summary' => $this->summary(),
            'cpu' => $this->cpu(),
            'memory' => $this->memory(),
            'disk' => $this->disk(),
        ];
    }

    /**
     * @return ?array
     */
    protected function summary(): ?array
    {
        return Summary::new()->get();
    }

    /**
     * @return ?array
     */
    protected function cpu(): ?array
    {
        return Cpu::new()->get();
    }

    /**
     * @return ?array
     */
    protected function memory(): ?array
    {
        return Memory::new()->get();
    }

    /**
     * @return ?array
     */
    protected function disk(): ?array
    {
        return Disk::new()->get();
    }
}
