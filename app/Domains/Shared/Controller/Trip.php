<?php declare(strict_types=1);

namespace App\Domains\Shared\Controller;

use Illuminate\Http\Response;
use App\Domains\Position\Model\Collection\Position as PositionCollection;
use App\Domains\Trip\Model\Trip as Model;
use App\Exceptions\NotFoundException;

class Trip extends ControllerAbstract
{
    /**
     * @var \App\Domains\Trip\Model\Trip
     */
    protected Model $row;

    /**
     * @param string $code
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(string $code): Response
    {
        $this->row($code);

        $this->meta('title', __('shared-trip.meta-title', ['title' => $this->row->name]));

        return $this->page('shared.trip', [
            'row' => $this->row,
            'device' => $this->row->device,
            'positions' => $this->positions(),
            'stats' => $this->row->stats,
        ]);
    }

    /**
     * @param string $code
     *
     * @return void
     */
    protected function row(string $code): void
    {
        $this->row = Model::query()->byCode($code)->whereShared()->firstOr(static function () {
            throw new NotFoundException(__('shared-trip.error.not-found'));
        });

        $this->factory('User', $this->row->user)->action()->set();
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
