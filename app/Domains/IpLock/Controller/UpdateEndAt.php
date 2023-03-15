<?php declare(strict_types=1);

namespace App\Domains\IpLock\Controller;

use Illuminate\Http\RedirectResponse;

class UpdateEndAt extends ControllerAbstract
{
    /**
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(int $id): RedirectResponse
    {
        $this->row($id);

        $this->actionCall('updateEndAt');

        return redirect()->back();
    }

    /**
     * @return void
     */
    protected function updateEndAt(): void
    {
        $this->factory()->action()->updateEndAt();
    }
}
