<?php declare(strict_types=1);

namespace App\Domains\User\Controller;

use Illuminate\Http\Response;
use App\Domains\User\Model\User as Model;

class Index extends ControllerAbstract
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function __invoke(): Response
    {
        $this->meta('title', __('user-index.meta-title'));

        return $this->page('user.index', [
            'list' => Model::query()->list()->get(),
        ]);
    }
}
