<?php declare(strict_types=1);

namespace App\Domains\Timezone\Controller;

use Illuminate\Http\Response;
use App\Domains\Timezone\Model\Timezone as Model;

class Index extends ControllerAbstract
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function __invoke(): Response
    {
        $this->meta('title', __('timezone-index.meta-title'));

        return $this->page('timezone.index', [
            'list' => Model::query()->list()->get(),
        ]);
    }
}
