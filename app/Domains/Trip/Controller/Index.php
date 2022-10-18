<?php declare(strict_types=1);

namespace App\Domains\Trip\Controller;

use Illuminate\Http\Response;
use App\Domains\Trip\Model\Trip as Model;

class Index extends ControllerAbstract
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function __invoke(): Response
    {
        $this->meta('title', __('trip-index.meta-title'));

        return $this->page('trip.index', [
            'list' => Model::byUserId($this->auth->id)->list()->get(),
        ]);
    }
}
