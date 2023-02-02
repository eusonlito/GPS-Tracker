<?php declare(strict_types=1);

namespace App\Domains\Trip\Controller;

use Illuminate\Http\Response;
use App\Domains\Position\Model\Collection\Position as PositionCollection;

class Shared extends ControllerAbstract
{
    /**
     * @param string $code
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(string $code): Response
    {
        $this->rowShared($code);

        $this->meta('title', $this->row->name);

        return $this->page('trip.shared', [
            'row' => $this->row,
            'positions' => $this->positions(),
            'stats' => $this->row->stats,
        ]);
    }

    /**
     * @return \App\Domains\Position\Model\Collection\Position
     */
    protected function positions(): PositionCollection
    {
        return $this->row->positions()
            ->withCity()
            ->list()
            ->get();
    }
}
