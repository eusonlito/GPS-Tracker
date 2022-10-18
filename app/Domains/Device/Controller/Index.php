<?php declare(strict_types=1);

namespace App\Domains\Device\Controller;

use Illuminate\Http\Response;
use App\Domains\Device\Model\Device as Model;

class Index extends ControllerAbstract
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function __invoke(): Response
    {
        $this->meta('title', __('device-index.meta-title'));

        return $this->page('device.index', [
            'list' => Model::byUserId($this->auth->id)->withTimezone()->list()->get(),
        ]);
    }
}
