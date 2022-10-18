<?php declare(strict_types=1);

namespace App\Domains\Trip\Controller;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

class UpdateMap extends UpdateAbstract
{
    /**
     * @param int $id
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function __invoke(int $id): Response|RedirectResponse
    {
        $this->load($id);

        $this->meta('title', $this->row->name);

        return $this->page('trip.update-map', [
            'positions' => $this->row->positions()->selectPointAsLatitudeLongitude()->list()->get(),
        ]);
    }
}
