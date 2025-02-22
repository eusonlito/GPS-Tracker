<?php declare(strict_types=1);

namespace App\Domains\Permissions\Controller;

use Illuminate\Http\Response;

class Create extends ControllerAbstract
{
    public function __invoke(): Response
    {
        $this->meta('title', __('permissions-create.meta-title'));

        return $this->page('permissions.create', []);
    }
}
